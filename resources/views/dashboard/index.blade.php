<x-app-layout>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MQTT Dashboard</title>
        <!-- Include DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
        <!-- Include Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
        <style>
            table th, table td {
                text-align: center;
                vertical-align: middle;
            }
            table thead th {
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <div class="py-12">
            <div class="container">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">MQTT Dashboard</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <!-- Tabel MQTT -->
                        <table id="mqttTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>MQTT ID</th>
                                    <th>Topic</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mqtts as $index => $mqtt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mqtt->mqtt_id }}</td>
                                        <td>{{ $mqtt->topic }}</td>
                                        <td>
                                            <a href="{{ route('mqtt.show', $mqtt->topic) }}" class="btn btn-info btn-sm">Lihat Data</a>
                                            <form action="{{ route('user.delete') }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="mqtt_id" value="{{ $mqtt->mqtt_id }}">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus MQTT ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#mqttTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "language": {
                        "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                        "zeroRecords": "Belum Ada Data",
                        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                        "infoEmpty": "Tidak ada data tersedia",
                        "search": "Cari:",
                        "paginate": {
                            "first": "Awal",
                            "last": "Akhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            });
        </script>
    </body>
    </html>
</x-app-layout>
