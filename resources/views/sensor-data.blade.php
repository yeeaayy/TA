<x-app-layout>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sensor Data</title>
        <!-- Include Plotly.js -->
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <!-- Include jQuery and DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <style>
            table.dataTable tbody td {
                text-align: center; /* Pusatkan secara horizontal */
                vertical-align: middle; /* Pusatkan secara vertikal */
            }
        </style>
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <h1>Data untuk Topic: {{ $topic }}</h1>
    
                    <!-- Tampilkan Grafik menggunakan Plotly.js -->
                    <div id="sensorChart" style="height: 400px;"></div>
    
                    <!-- Tabel Data -->
                    <h2 class="mt-4">Tabel Data</h2>
                    <table class="table table-striped" id="sensorTable">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Voltage (V)</th>
                                <th>Current (A)</th>
                                <th>Power (W)</th>
                                <th>Energy (kWh)</th> <!-- Kolom baru -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi di sini -->
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    
        <script>
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
            console.log("Data fetched:", parsedData);

            if (!parsedData || !Array.isArray(parsedData.original)) {
                throw new Error("Invalid data format received from API.");
            }

            const data = parsedData.original;

            const voltageData = data
                .filter(record => record.field === 'voltage')
                .map(record => ({ time: new Date(record.time), value: record.value }));
            const currentData = data
                .filter(record => record.field === 'current')
                .map(record => ({ time: new Date(record.time), value: record.value }));
            const powerData = data
                .filter(record => record.field === 'power')
                .map(record => ({ time: new Date(record.time), value: record.value }));
            const energyData = data
                .filter(record => record.field === 'energy')
                .map(record => ({ time: new Date(record.time), value: record.value }));

            const currentMap = new Map();
            const powerMap = new Map();
            const energyMap = new Map();

            currentData.forEach(record => {
                currentMap.set(Math.round(record.time.getTime() / 1000), record.value);
            });
            powerData.forEach(record => {
                powerMap.set(Math.round(record.time.getTime() / 1000), record.value);
            });
            energyData.forEach(record => {
                energyMap.set(Math.round(record.time.getTime() / 1000), record.value);
            });

            const combinedData = voltageData.map(voltageRecord => {
                const timeKey = Math.round(voltageRecord.time.getTime() / 1000);
                return {
                    time: voltageRecord.time,
                    voltage: voltageRecord.value,
                    current: currentMap.get(timeKey) || null,
                    power: powerMap.get(timeKey) || null,
                    energy: energyMap.get(timeKey) || null,
                };
            });

            const plotData = [
                {
                    x: voltageData.map(d => d.time),
                    y: voltageData.map(d => d.value),
                    type: 'scatter',
                    mode: 'lines+markers',
                    name: 'Voltage',
                    line: { color: 'orange' }
                },
                {
                    x: currentData.map(d => d.time),
                    y: currentData.map(d => d.value),
                    type: 'scatter',
                    mode: 'lines+markers',
                    name: 'Current',
                    line: { color: 'green' }
                },
                {
                    x: powerData.map(d => d.time),
                    y: powerData.map(d => d.value),
                    type: 'scatter',
                    mode: 'lines+markers',
                    name: 'Power',
                    line: { color: 'blue' }
                },
                {
                    x: energyData.map(d => d.time),
                    y: energyData.map(d => d.value),
                    type: 'scatter',
                    mode: 'lines+markers',
                    name: 'Energy',
                    line: { color: 'purple' }
                }
            ];

            const layout = {
                title: 'Sensor Data',
                xaxis: {
                    title: 'Time',
                    type: 'date',
                },
                yaxis: {
                    title: 'Value',
                }
            };

            Plotly.newPlot('sensorChart', plotData, layout);

            const table = $('#sensorTable').DataTable();
            table.clear();

            combinedData.forEach(record => {
                table.row.add([
                    record.time.toLocaleString(),
                    record.voltage.toFixed(2),
                    record.current !== null ? record.current.toFixed(2) : '-',
                    record.power !== null ? record.power.toFixed(2) : '-',
                    record.energy !== null ? record.energy.toFixed(2) : '-' // Tambahkan energy
                ]);
            });

            table.draw();
        })
        .catch(error => {
            console.error("Error fetching data:", error);
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
    