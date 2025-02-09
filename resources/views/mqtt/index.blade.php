<x-app-layout>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MQTT User Management</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container py-4">
                    <h1>Manajemen Pengguna MQTT</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        Tambah Pengguna
                    </button>

                    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createUserModalLabel">Buat Pengguna MQTT Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('user.create') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="mqtt_id" class="form-label">User ID</label>
                                            <input type="text" name="mqtt_id" class="form-control" id="mqtt_id" placeholder="Masukkan User ID" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="topic" class="form-label">Topic</label>
                                            <input type="text" name="topic" class="form-control" id="topic" placeholder="Masukkan Topic" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Buat User</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2>Daftar Pengguna MQTT</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>Topic</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mqtts as $mqtt)
                                <tr>
                                    <td>{{ $mqtt->mqtt_id }}</td>
                                    <td>{{ $mqtt->password }}</td>
                                    <td>{{ $mqtt->topic }}</td>
                                    <td>

                                        <form action="{{ route('user.delete') }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="mqtt_id" value="{{ $mqtt->mqtt_id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada pengguna MQTT.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
</x-app-layout>