<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model
{
    protected $table = 'transaksi_kass';

    protected $fillable = [
        'jenis',
        'jumlah',
        'referensi_type',
        'referensi_id',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function referensi()
    {
        return $this->morphTo();
    }
}
