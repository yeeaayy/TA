<?php
namespace App\Services;

use InfluxDB2\Client;

class InfluxDBService
{
    private $client;
    private $bucket = 'emqx'; // Gunakan bucket yang Anda sebutkan
    private $org = 'UPI'; // Pastikan sesuai organisasi InfluxDB Anda
    private $token = 'wc24SlOD_lgXOO5MabKo7TgY6DoM3AwouY_Vq4U9r5ZutuSzPtiRN7GqWE4NMbYHg144Em3zNJRgGjPEpi70YA==';
    private $url = 'http://localhost:8086'; // Ubah sesuai URL InfluxDB Anda

    public function __construct()
    {
        $this->client = new Client([
            'url' => $this->url,
            'token' => $this->token,
            'org' => $this->org,
            'bucket' => $this->bucket,
        ]);
    }

    public function getSensorData($timeRange, $measurement)
{
    $query = "from(bucket: \"$this->bucket\")
              |> range(start: $timeRange)
              |> filter(fn: (r) => r._measurement == \"$measurement\")
              |> filter(fn: (r) => r._field == \"voltage\" or r._field == \"current\" or r._field == \"power\" or r._field == \"energy\")";

    $queryApi = $this->client->createQueryApi();

    try {
        $data = $queryApi->query($query);

        $formattedData = [];
        foreach ($data as $table) {
            foreach ($table->records as $record) {
                $formattedData[] = [
                    'time' => $record->getTime(),
                    'field' => $record->getField(),
                    'value' => $record->getValue(),
                ];
            }
        }

        return $formattedData;
    } catch (\Exception $e) {
        return ['error' => 'Query gagal: ' . $e->getMessage()];
    }
}
}