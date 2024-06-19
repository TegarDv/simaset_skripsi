<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsTransaction extends Model
{
    use HasFactory;

    protected $table = "transkasi_aset";

    protected $fillable = [
        'asset_id',
        'user_id',
        'tipe_transaksi',
        'kode_transaksi',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'tanggal_transaksi',
        'created_at',
        'updated_at',
    ];
}
