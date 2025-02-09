<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold mb-6">Panduan Penggunaan Aplikasi</h1>
        
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Langkah 1: Membuat Username, Password, dan Topic</h2>
                <p>
                    Pada menu <strong>MQTT User</strong>, silakan buat <strong>Username</strong>, <strong>Password</strong>, 
                    dan <strong>Topic</strong>. Data ini akan digunakan untuk autentikasi perangkat IoT Anda.
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Langkah 2: Mengunduh Source Code untuk Arduino</h2>
                <p>
                    Setelah selesai membuat Username, Password, dan Topic, Anda dapat mengunduh 
                    <strong>source code</strong> Arduino yang telah kami sediakan. 
                    Source code ini akan mempermudah perangkat Anda untuk terhubung ke sistem.
                </p>
                <a href="{{ route('download.arduino') }}" 
                   class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                    Download Source Code
                </a>

            </div>

            <!-- Step 3 -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Langkah 3: Melihat Data dari Perangkat IoT</h2>
                <p>
                    Jika perangkat Arduino Anda berhasil terhubung dan mengirimkan data, Anda dapat melihat 
                    data yang terkirim pada halaman <strong>Dashboard</strong>. 
                    Klik tombol <strong>Lihat Data</strong> untuk melihat detail data yang masuk.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
