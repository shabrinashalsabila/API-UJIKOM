@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('header-title', 'Log Aktivitas')

@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

    {{-- Header --}}
    <div class="p-5 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-800">
            Log Aktivitas Terbaru
        </h3>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">

                    <th class="py-3 px-4 border-b">
                        WAKTU
                    </th>

                    <th class="py-3 px-4 border-b">
                        USER
                    </th>

                    <th class="py-3 px-4 border-b">
                        AKTIVITAS
                    </th>

                </tr>
            </thead>

            <tbody class="text-gray-700 text-sm">

                @forelse($logs as $log)

                    <tr class="hover:bg-gray-50 transition">

                        {{-- Waktu --}}
                        <td class="py-3 px-4 border-b">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>

                        {{-- User --}}
                        <td class="py-3 px-4 border-b font-medium text-gray-900">
                            {{ $log->user->name ?? 'Sistem' }}
                        </td>

                        {{-- Aktivitas --}}
                        <td class="py-3 px-4 border-b">
                            {{ $log->Aktivitas }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3"
                            class="py-6 text-center text-gray-500">

                            Belum ada log aktivitas.

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())

        <div class="p-4 border-t border-gray-200">
            {{ $logs->links() }}
        </div>

    @endif

</div>

@endsection