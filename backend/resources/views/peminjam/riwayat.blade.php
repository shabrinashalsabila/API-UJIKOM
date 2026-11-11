<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased min-h-screen">

    <!-- Header Navbar khusus Peminjam -->
    <nav class="bg-blue-600 text-white shadow-md py-4 px-8 flex justify-between items-center">
        <h1 class="text-xl font-bold tracking-wide">Panel Peminjam</h1>
        <div class="flex space-x-3">
            <a href="{{ route('peminjam.katalog') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 rounded-lg text-sm font-medium transition flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Katalog Alat
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
        
        {{-- Alert Notifikasi Success / Error --}}
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

        <!-- Banner Judul Halaman -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman Saya</h2>
                <p class="text-gray-500 text-sm mt-1">Pantau status pengajuan dan daftar alat yang pernah kamu pinjam.</p>
            </div>
            <a href="{{ route('peminjam.katalog') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition flex items-center gap-2">
                <span>+</span> Pinjam Alat Lain
            </a>
        </div>

        <!-- Tabel Riwayat Peminjaman -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-12">No</th>
                            <th class="py-4 px-6">Tanggal Pinjam</th>
                            <th class="py-4 px-6">Rencana Kembali</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6">Daftar Alat Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($peminjamans as $index => $peminjaman)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-6 text-center font-medium text-gray-500">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-4 px-6 font-medium text-gray-800 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="py-4 px-6 text-gray-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_plan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @php
                                    $status = strtolower($peminjaman->status);
                                @endphp

                                @if($status == 'diajukan' || $status == 'pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Diajukan
                                    </span>
                                @elseif($status == 'dipinjam' || $status == 'disetujui')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        Dipinjam
                                    </span>
                                @elseif($status == 'selesai' || $status == 'dikembalikan')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        Selesai
                                    </span>
                                @elseif($status == 'ditolak')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ ucfirst($peminjaman->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <ul class="space-y-1.5">
                                    @foreach($peminjaman->detailPinjams as $detail)
                                        <li class="flex items-center text-gray-700">
                                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2.5"></span>
                                            <span class="font-medium text-gray-900 mr-1.5">{{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}</span>
                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded border border-gray-200">({{ $detail->jumlah }} unit)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="font-medium text-gray-600">Belum ada riwayat peminjaman.</p>
                                    <a href="{{ route('peminjam.katalog') }}" class="mt-2 text-sm text-blue-600 hover:underline font-semibold">
                                        Mulai pinjam barang sekarang &rarr;
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>