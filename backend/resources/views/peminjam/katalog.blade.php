<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Alat - Panel Peminjam</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased min-h-screen pb-24">

    <!-- Header Navbar -->
    <nav class="bg-blue-600 text-white shadow-md py-4 px-8 flex justify-between items-center sticky top-0 z-40">
        <h1 class="text-xl font-bold tracking-wide">Panel Peminjam</h1>
        <div class="flex space-x-3">
            <a href="{{ route('peminjam.riwayat') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 rounded-lg text-sm font-medium transition flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Riwayat Pinjam
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-center justify-between">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form Pengajuan Peminjaman -->
        <form action="{{ route('peminjam.store') }}" method="POST" id="form-pinjam">
            @csrf

            <!-- Header Card & Input Tanggal + Fitur Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-100 pb-6 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Katalog Alat Tersedia</h2>
                        <p class="text-gray-500 text-sm mt-1">Pilih barang yang ingin dipinjam dan tentukan tanggal pengembaliannya.</p>
                    </div>

                    <!-- Input Rencana Tanggal Kembali -->
                    <div class="w-full md:w-auto">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">
                            Rencana Tanggal Kembali <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tgl_kembali_plan" required min="{{ date('Y-m-d') }}"
                            class="w-full md:w-64 px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <!-- Live Search Bar -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search-input" onkeyup="filterAlat()" placeholder="Cari nama barang atau kategori alat..."
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition shadow-sm">
                </div>
            </div>

            <!-- Grid Card Daftar Alat -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="katalog-grid">
                @forelse($alats as $alat)
                    <div class="alat-card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-5 flex flex-col justify-between"
                         data-nama="{{ strtolower($alat->nama_alat) }}" 
                         data-kategori="{{ strtolower($alat->kategori->nama_kategori ?? '') }}">
                        
                        <div>
                            <!-- Kategori & Stok Badge -->
                            <div class="flex justify-between items-center mb-3">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                    {{ $alat->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $alat->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    Stok: {{ $alat->stok }}
                                </span>
                            </div>

                            <!-- Nama Alat -->
                            <h3 class="font-bold text-gray-800 text-lg mb-4 line-clamp-2">{{ $alat->nama_alat }}</h3>

                            <!-- Checkbox Pilih Barang -->
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 mb-4">
                                <label class="flex items-center space-x-3 cursor-pointer select-none">
                                    <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" 
                                        class="checkbox-alat w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                        {{ $alat->stok < 1 ? 'disabled' : '' }}>
                                    <span class="text-sm font-medium text-gray-700">Pilih Barang Ini</span>
                                </label>
                            </div>
                        </div>

                        <!-- Input Jumlah Pinjam -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                            <span class="text-xs font-medium text-gray-500">Jumlah Pinjam</span>
                            <input type="number" name="jumlah[{{ $alat->id }}]" value="1" min="1" max="{{ $alat->stok }}"
                                class="w-20 px-2 py-1 text-center bg-gray-50 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                {{ $alat->stok < 1 ? 'disabled' : '' }}>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-200">
                        <p class="font-medium">Tidak ada alat yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pesan Jika Hasil Pencarian Kosong -->
            <div id="no-result" class="hidden col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="font-medium text-gray-600">Barang yang kamu cari tidak ditemukan.</p>
            </div>

            <!-- Fixed Bottom Action Bar -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg py-4 px-8 z-30">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-3">
                    <p class="text-sm text-gray-600">Pastikan pilihan dan tanggal kembali sudah sesuai.</p>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow transition">
                        Ajukan Peminjaman
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!-- Script Search Real-Time -->
    <script>
        function filterAlat() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const cards = document.querySelectorAll('.alat-card');
            const noResult = document.getElementById('no-result');
            let hasVisible = false;

            cards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const kategori = card.getAttribute('data-kategori');

                if (nama.includes(searchInput) || kategori.includes(searchInput)) {
                    card.classList.remove('hidden');
                    hasVisible = true;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (hasVisible) {
                noResult.classList.add('hidden');
            } else {
                noResult.classList.remove('hidden');
            }
        }
    </script>''
    submit

</body>
</html>