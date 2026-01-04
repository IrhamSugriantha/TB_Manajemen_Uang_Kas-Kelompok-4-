<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranKas extends Model
{
    protected $table = 'pembayaran_kass';

    protected $fillable = [
        'mahasiswa_id',
        'kas_bulanan_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'keterangan',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function kasBulanan()
    {
        return $this->belongsTo(KasBulanan::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
