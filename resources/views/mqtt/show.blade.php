<x-app-layout>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sensor Data</title>
        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Include jQuery and DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1>Data untuk Topic: {{ $topic }}</h1>
    
                    <!-- Chart -->
                    <canvas id="sensorChart" width="400" height="200"></canvas>
    
                    <!-- Tabel Data -->
                    <h2 class="mt-4">Tabel Data</h2>
                    <table class="table table-striped" id="sensorTable">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Field</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <script>
        let chart = null;
    
    const loadData = () => {
    const topic = "{{ $topic }}";

    fetch(`/sensor-data/${topic}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(parsedData => {
            console.log("Data fetched:", parsedData); // Debug respons API
            if (!parsedData || !Array.isArray(parsedData.original)) {
                throw new Error("Invalid data format received from API.");
            }

            const data = parsedData.original;

            const temperatureData = data
                .filter(record => record.field === 'temperature')
                .map(record => ({ x: new Date(record.time), y: record.value }));
            const humidityData = data
                .filter(record => record.field === 'humidity')
                .map(record => ({ x: new Date(record.time), y: record.value }));

            // Temukan elemen canvas
            const canvas = document.getElementById('sensorChart');
            if (!canvas) {
                throw new Error("Canvas element with id 'sensorChart' not found.");
            }

            const ctx = canvas.getContext('2d');

            // Hancurkan chart lama jika sudah ada
            if (chart) {
                chart.destroy();
                chart = null; // Pastikan chart di-reset
            }

            // Buat chart baru
            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [
                        {
                            label: 'Temperature',
                            data: temperatureData,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                        },
                        {
                            label: 'Humidity',
                            data: humidityData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                        },
                    ],
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                tooltipFormat: 'MMM DD, YYYY HH:mm:ss',
                                unit: 'minute',
                            },
                            title: {
                                display: true,
                                text: 'Time',
                            },
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Value',
                            },
                        },
                    },
                },
            });
        })
        .catch(error => {
            console.error("Error fetching data:", error); // Menampilkan error ke konsol
            alert("Terjadi kesalahan saat memuat data: " + error.message);
        });
};

// Jalankan loadData pertama kali
loadData();

// Atur interval untuk memuat data secara berkala
setInterval(loadData, 5000);
    </script>
    </body>
    </html>
</x-app-layout>
