<x-app-layout>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <!-- Include Plotly.js -->
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <!-- Include jQuery and DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1>Dashboard</h1>
                    <p>Selamat datang, {{ Auth::user()->name }}</p>

                    <!-- Tabel Data MQTT -->
                    <h2 class="mt-4">Data MQTT</h2>
                    <table class="table table-striped" id="mqttTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>MQTT ID</th>
                                <th>Topic</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mqtts as $index => $mqtt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $mqtt->mqtt_id }}</td>
                                    <td>{{ $mqtt->topic }}</td>
                                    <td>
                                        <a href="{{ url('/sensor-data/' . $mqtt->topic) }}" class="btn btn-primary">Lihat Data</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#mqttTable').DataTable();
            });
        </script>
    </body>
    </html>
</x-app-layout>
