@extends('layouts.app')

@section('title', 'Profil Pengguna')
@section('header-title', 'Profil Saya')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- Notifikasi Berhasil -->
    @if(session('success'))
        <div class="mb-5 p-4 bg-green-100 border border-green-300 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if($errors->any())
        <div class="mb-5 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-blue-600 p-6 text-white">
            <h2 class="text-xl font-bold">Pengaturan Profil</h2>
            <p class="text-sm text-blue-100 mt-1">
                Kelola informasi dan foto profil akun kamu.
            </p>
        </div>

        <form action="{{ route('profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6">

            @csrf
            @method('PUT')

            <!-- Foto Profil -->
            <div class="mb-8 flex flex-col items-center">

                @if($user->foto_profile)

                    <img
                        src="{{ asset('storage/' . $user->foto_profile) }}"
                        alt="Foto Profil"
                        class="w-32 h-32 rounded-full object-cover border-4 border-gray-200 shadow-sm">

                @else

                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-16 h-16 text-gray-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.5"
                                  d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                @endif

                <h3 class="mt-3 text-lg font-bold text-gray-800">
                    {{ $user->name }}
                </h3>

                <span class="mt-1 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 uppercase">
                    {{ $user->role }}
                </span>

                <!-- Input Foto -->
                <div class="mt-4 w-full max-w-sm">

                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ganti Foto Profil
                    </label>

                    <input
                        type="file"
                        name="foto_profile"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm border border-gray-300 rounded-lg p-2">

                    <p class="text-xs text-gray-500 mt-1">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                </div>

            </div>

            <hr class="mb-6">

            <!-- Nama Lengkap -->
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- Email -->
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- Nomor HP -->
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    value="{{ old('no_hp', $user->no_hp) }}"
                    placeholder="Masukkan nomor HP"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

            </div>

            <!-- Tombol -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 border-t pt-5">

                <a href="{{ url()->previous() }}"
                   class="px-5 py-3 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                    Kembali
                </a>

                <button
                    type="submit"
                    class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection