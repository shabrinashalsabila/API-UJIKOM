<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">

            <!-- JUDUL PANEL -->
            <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800">
                @if (auth()->user()->role === 'admin')
                    PANEL ADMIN
                @elseif (auth()->user()->role === 'petugas')
                    PANEL PETUGAS
                @elseif (auth()->user()->role === 'peminjam')
                    PANEL PEMINJAM
                @endif
            </div>

            <!-- MENU NAVIGASI -->
            <nav class="flex-1 p-4 space-y-2">

                <!-- MENU KHUSUS ADMIN -->
                @if (auth()->user()->role === 'admin')

                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.user.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.user*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola User
                    </a>

                    <a href="{{ route('admin.kategori.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.kategori*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Kategori
                    </a>

                    <a href="{{ route('admin.alat.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.alat*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Alat
                    </a>

                    <a href="{{ route('admin.peminjaman.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.peminjaman*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Peminjaman
                    </a>

                    <a href="{{ route('admin.pengembalian.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Kelola Pengembalian
                    </a>

                    <a href="{{ route('admin.logaktivitas.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('admin.logaktivitas*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Log Aktivitas
                    </a>

                @endif

                <!-- MENU KHUSUS PETUGAS -->
                @if (auth()->user()->role === 'petugas')

                    <a href="{{ route('petugas.peminjaman.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.peminjaman*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Persetujuan Peminjaman
                    </a>

                    <a href="{{ route('petugas.pengembalian.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.pengembalian*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Pemantauan Pengembalian
                    </a>

                    <a href="{{ route('petugas.laporan.index') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('petugas.laporan*') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Cetak Laporan
                    </a>

                @endif

                <!-- MENU KHUSUS PEMINJAM -->
                @if (auth()->user()->role === 'peminjam')

                    <a href="{{ route('peminjam.katalog') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('peminjam.katalog') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Katalog Alat
                    </a>

                    <a href="{{ route('peminjam.riwayat') }}"
                        class="block px-4 py-2 rounded-lg transition {{ request()->routeIs('peminjam.riwayat') ? 'bg-gray-800 text-white font-medium shadow' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Riwayat Pinjam
                    </a>

                @endif

            </nav>

            <!-- MENU PROFIL -->
            <div class="p-4 border-t border-gray-800">

                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 rounded-lg transition
                    {{ request()->routeIs('profile.*') ? 'bg-gray-800 text-white font-medium' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">

                    <div class="flex items-center gap-3">

                        <!-- FOTO PROFIL -->
                        @if (auth()->user()->foto_profile)

                            <img src="{{ asset('storage/' . auth()->user()->foto_profile) }}"
                                alt="Foto Profil"
                                class="w-9 h-9 rounded-full object-cover border border-gray-600">

                        @else

                            <div class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center">
                                <span class="text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>

                        @endif

                        <!-- INFORMASI PROFIL -->
                        <div>
                            <p class="text-sm font-semibold">
                                Profile Saya
                            </p>

                            <p class="text-xs text-gray-400">
                                Lihat dan edit profil
                            </p>
                        </div>

                    </div>

                </a>

            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-y-auto">

            <!-- HEADER -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">

                <div class="text-lg font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </div>

                <!-- TOMBOL LOGOUT -->
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>

            </header>

            <!-- ISI HALAMAN -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>