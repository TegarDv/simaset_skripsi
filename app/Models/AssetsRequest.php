<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AssetsRequest extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "permintaan_aset";

    protected $fillable = [
        'tipe_aset',
        'nama_aset',
        'harga',
        'spesifikasi',
        'keterangan',
        'stok_permintaan',
        'masa_berlaku',
        'created_at',
        'updated_at',
    ];
}
