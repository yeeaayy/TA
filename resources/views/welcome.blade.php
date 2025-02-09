<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Listrik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('electric-grid.jpg') no-repeat center center/cover;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .features {
            padding: 50px 15px;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 20px 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <div class="hero">
        <div>
            <h1>Selamat Datang di Monitoring Listrik</h1>
            <p>Mengontrol dan memantau konsumsi listrik Anda dengan mudah.</p>
            <a href="#features" class="btn btn-primary">mulai</a>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="text-center mb-4">Fitur Utama</h2>
            <div class="row text-center">
                <div class="col-md-6">
                    <div class="p-3">
                        <img src="{{ asset('image/realtime.png') }}" alt="Real-Time Monitoring" class="mb-3" style="width: 100px;">

                        <h5>Monitoring Real-Time</h5>
                        <p>Pantau penggunaan listrik Anda secara langsung.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3">
                        <img src="{{ asset('image/statistik.png') }}" alt="Real-Time Monitoring" class="mb-3" style="width: 60px;">

                        <h5>Statistik Terperinci</h5>
                        <p>Dapatkan laporan lengkap penggunaan energi Anda.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/login" class="btn btn-success px-4 py-2 mx-2">Login</a>
                <a href="/register" class="btn btn-warning px-4 py-2 mx-2">Register</a>
            </div>
        </div>
    </section>
    

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Monitoring Listrik. Semua Hak Dilindungi.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
