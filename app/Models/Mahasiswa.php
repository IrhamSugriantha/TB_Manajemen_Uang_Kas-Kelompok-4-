<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'jenis_kelamin',
        'no_telepon',
        'alamat',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaranKass()
    {
        return $this->hasMany(PembayaranKas::class);
    }
}
