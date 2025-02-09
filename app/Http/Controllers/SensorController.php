<?php

namespace App\Http\Controllers;

use App\Services\InfluxDBService;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function getSensorData($topic)
    {
        try {
            // Membuat instance dari service InfluxDB
            $influxDBService = new InfluxDBService();

            // Mengambil data berdasarkan topic dan rentang waktu 1 jam
            $data = $influxDBService->getSensorData('-1h', $topic);

            // Jika data kosong, kembalikan response error 404
            if (empty($data)) {
                return response()->json(['message' => 'Data tidak ditemukan atau Anda tidak memiliki akses.'], 404);
            }

            // Mengembalikan data dengan status 200 jika berhasil
            return response()->json(['original' => $data], 200);

        } catch (\Exception $e) {
            // Menangani error jika terjadi kesalahan pada query atau bagian lainnya
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
