<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Peminjaman Alat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-6">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">

        <h3 class="text-2xl font-bold text-center text-gray-800 mb-2">
            Register
        </h3>

        <p class="text-sm text-gray-500 text-center mb-6">
            Silakan buat akun baru
        </p>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Nama Lengkap
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="Masukkan email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Nomor HP
                </label>
                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" maxlength="13" required
                    placeholder="Masukkan nomor HP"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Password
                </label>
                <input type="password" name="password" minlength="8" required
                    placeholder="Minimal 8 karakter"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" required
                    placeholder="Ulangi password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                Daftar
            </button>
        </form>

        <div class="mt-5 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                Login di sini
            </a>
        </div>

    </div>

</body>
</html>