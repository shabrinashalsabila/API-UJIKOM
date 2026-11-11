@extends('layouts.app')

@section('title', 'Tambah Peminjaman - Panel Admin')
@section('header-title', 'Form Tambah Transaksi Peminjaman')

@section('content')
<!-- Include CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Penyesuaian tampilan Select2 agar cocok dengan Tailwind CSS */
    .select2-container--default .select2-selection--single {
        height: 42px;
        border-color: #D1D5DB;
        border-radius: 0.5rem;
        padding-top: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
</style>

<div class="max-w-2xl bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Pilih Peminjam (User)</label>
            <select name="user_id" required class="select2-search w-full">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-semibold mb-2">Rencana Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_plan" value="{{ old('tgl_kembali_plan', date('Y-m-d', strtotime('+3 days'))) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Daftar Alat yang Dipinjam</label>
            <div id="alat-container" class="space-y-3">
                <div class="flex items-center gap-2 alat-row">
                    <div class="flex-1">
                        <select name="alat_id[]" required class="select2-alat w-full">
                            <option value="">-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                                <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="number" name="jumlah[]" value="1" min="1" placeholder="Jumlah" required
                        class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                    <button type="button" onclick="removeRow(this)" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-600 transition">✕</button>
                </div>
            </div>
            <button type="button" onclick="addRow()" class="mt-3 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                + Tambah Alat Lain
            </button>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.peminjaman.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Simpan Peminjaman</button>
        </div>
    </form>
</div>

<!-- Include JS JQuery & Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        initSelect2();
    });

    function initSelect2() {
        $('.select2-search').select2({
            placeholder: "-- Pilih User --",
            allowClear: true
        });

        $('.select2-alat').select2({
            placeholder: "-- Pilih Alat --",
            allowClear: true
        });
    }

    function addRow() {
        const container = document.getElementById('alat-container');
        const firstRow = container.querySelector('.alat-row');
        
        // Destroy instance Select2 sebelum me-clone elemen HTML
        $(firstRow).find('.select2-alat').select2('destroy');
        
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('select').value = '';
        newRow.querySelector('input').value = '1';
        
        container.appendChild(newRow);

        // Inisialisasi ulang Select2 untuk elemen lama & elemen baru
        initSelect2();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.alat-row');
        if (rows.length > 1) {
            button.closest('.alat-row').remove();
        } else {
            alert('Minimal harus ada 1 alat yang dipilih.');
        }
    }
</script>
@endsection