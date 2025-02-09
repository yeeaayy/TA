<?php

namespace App\Http\Controllers;

use App\Models\MqttUser;
use Illuminate\Http\Request;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MqttUserController extends Controller
{
    public function index()
    {
        $mqtts = MqttUser::where('user_id', Auth::id())->get();
        return view('mqtt.index', compact('mqtts'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'mqtt_id' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'topic' => 'required|string',
        ]);

        $mqttData = [
            'user_id' => Auth::id(),
            'mqtt_id' => $request->mqtt_id,
            'password' => $request->password,
            'topic' => $request->topic,
        ];

        $mqtt = MqttUser::create($mqttData);

        $responseUser = Http::withBasicAuth('aa79bce7a2e43ef5', '1Zrr37J6U4kmBT9C39C9C15C4uazKD9BT306kQcamCNUfeA')
            ->post('http://localhost:18083/api/v5/authentication/password_based%3Abuilt_in_database/users', [
                'user_id' => $mqtt->mqtt_id,
                'password' => $mqtt->password,
            ]);

        if ($responseUser->successful()) {
            Http::withBasicAuth('aa79bce7a2e43ef5', '1Zrr37J6U4kmBT9C39C9C15C4uazKD9BT306kQcamCNUfeA')
                ->post('http://localhost:18083/api/v5/mqtt/topic_metrics', [
                    'topic' => $mqtt->topic,
                ]);

            $responseAction = Http::withBasicAuth('aa79bce7a2e43ef5', '1Zrr37J6U4kmBT9C39C9C15C4uazKD9BT306kQcamCNUfeA')
                ->post('http://localhost:18083/api/v5/actions', [
                    "name" => "new_datas_" . $mqtt->mqtt_id,
                    "type" => "influxdb",
                    "enable" => true,
                    "connector" => "influx",
                    "description" => "InfluxDB configuration for " . $mqtt->mqtt_id,
                    "parameters" => [
                        "precision" => "ms",
                        "write_syntax" => "{$mqtt->topic} voltage=\${voltage},current=\${current},power=\${power},energy=\${energy} \${timestamp}"
                    ],
                    "resource_opts" => [
                        "batch_size" => 100,
                        "batch_time" => "0ms",
                        "health_check_interval" => "15s",
                        "inflight_window" => 100,
                        "max_buffer_bytes" => "1GB",
                        "query_mode" => "async",
                        "request_ttl" => "45s",
                        "worker_pool_size" => 4,
                    ]
                ]);

            if (!$responseAction->successful()) {
                return redirect()->back()->with('error', 'Gagal membuat action di API: ' . $responseAction->body());
            }

            $responseRule = Http::withBasicAuth('aa79bce7a2e43ef5', '1Zrr37J6U4kmBT9C39C9C15C4uazKD9BT306kQcamCNUfeA')
                ->post('http://localhost:18083/api/v5/rules', [
                    "name" => "rule_" . $mqtt->mqtt_id,
                    "sql" => "SELECT payload.voltage AS voltage, payload.current AS current, payload.power AS power, payload.energy AS energy, timestamp AS timestamp FROM \"#\" WHERE topic = '{$mqtt->topic}'",
                    "actions" => [
                        "influxdb:new_datas_" . $mqtt->mqtt_id
                    ],
                    "enable" => true,
                    "description" => "Monitoring data voltage, current, power, dan energy untuk " . $mqtt->mqtt_id,
                    "metadata" => new \stdClass(),
                ]);

            if (!$responseRule->successful()) {
                return redirect()->back()->with('error', 'Gagal membuat rule di API: ' . $responseRule->body());
            }
        } else {
            return redirect()->back()->with('error', 'Gagal membuat user di API: ' . $responseUser->body());
        }

        return redirect()->back()->with('success', 'User MQTT, action, dan rule berhasil dibuat!');
    }

    public function show($topic)
    {
        $influxDBService = new InfluxDBService();
        $data = $influxDBService->getSensorData('-1h', $topic);

        if (empty($data)) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        return view('sensor-data', ['data' => $data, 'topic' => $topic]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'mqtt_id' => 'required|string',
        ]);

        $mqtt = MqttUser::where('mqtt_id', $request->mqtt_id)->where('user_id', Auth::id())->first();

        if (!$mqtt) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $mqtt->delete();

        $response = Http::withBasicAuth('aa79bce7a2e43ef5', '1Zrr37J6U4kmBT9C39C9C15C4uazKD9BT306kQcamCNUfeA')
            ->delete('http://localhost:18083/api/v5/authentication/password_based%3Abuilt_in_database/users/' . $request->mqtt_id);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'User MQTT berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Gagal menghapus user di API: ' . $response->body());
    }
}
