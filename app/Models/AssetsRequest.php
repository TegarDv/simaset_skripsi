<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'pemilik_aset',
        'masa_berlaku',
        'created_at',
        'updated_at',
    ];

    public function dataUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_aset')->with('dataRole');
    }
}
