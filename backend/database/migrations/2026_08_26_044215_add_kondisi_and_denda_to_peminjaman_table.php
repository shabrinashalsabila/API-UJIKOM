<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('kondisi_kembali')->nullable()->after('status');
            $table->decimal('denda', 10, 2)->default(0)->after('kondisi_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['kondisi_kembali', 'denda']);
        });
    }
};