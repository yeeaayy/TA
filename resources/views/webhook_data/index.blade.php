<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sensor dari Webhook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Data Sensor dari Webhook</h1>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">Waktu</th>
                    <th scope="col">Topik</th>
                    <th scope="col">Temperatur</th>
                    <th scope="col">Kelembaban</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $item['time'] }}</td>
                        <td>{{ $item['topic'] }}</td>
                        <td>{{ $item['temperature'] ?? 'N/A' }}</td>
                        <td>{{ $item['humidity'] ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
