<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasBulanan extends Model
{
    protected $table = 'kas_bulanan';

    protected $fillable = [
        'bulan',
        'tahun',
        'nominal',
        'keterangan',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pembayaranKass()
    {
        return $this->hasMany(PembayaranKas::class);
    }
}
