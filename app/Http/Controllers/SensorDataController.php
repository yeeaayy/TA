<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SensorDataController extends Controller
{
    public function getSensorData($topic)
{
    $influxDBService = new \App\Services\InfluxDBService();

    // Mengambil data sensor berdasarkan measurement (yang sama dengan topic)
    $data = $influxDBService->getSensorData('-30d', $topic); // Mengambil data 1 jam terakhir berdasarkan topic

    return response()->json($data);
}

}
