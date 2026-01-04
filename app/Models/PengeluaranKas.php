<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengeluaranKas extends Model
{
    protected $table = 'pengeluaran_kass';

    protected $fillable = [
        'tanggal',
        'jumlah',
        'kategori',
        'keterangan',
        'bukti_path',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
