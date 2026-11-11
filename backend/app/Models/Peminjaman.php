<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
    'user_id',
    'tgl_pinjam',
    'tgl_kembali_plan',
    'status',
    'kondisi_kembali', 
    'denda',           
];
    protected function casts(): array 
    {
        return [
            'tgl_pinjam' => 'date:Y-m-d',
            'tgl_kembali_plan' => 'date:Y-m-d',
        ];
    }
    
<<<<<<< HEAD
    public function user(): BelongsTo
{
    return $this->belongsTo(User::class)->withTrashed();
}
=======
    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
>>>>>>> 910a5db3b8915f0e8467a9af53a060db3e0fe71e

    // Diubah menjadi jamak (detailPinjams) agar cocok dengan Controller Anda
    public function detailPinjams(): HasMany 
    {
        return $this->hasMany(DetailPinjam::class);
    }

    public function pengembalian(): HasOne 
    {
        return $this->hasOne(Pengembalian::class);
    }
}