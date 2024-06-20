<?php

namespace App\Models;

use App\Models\Assets;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetsTransaction extends Model
{
    use HasFactory;

    protected $table = "transkasi_aset";

    protected $fillable = [
        'asset_id',
        'user_id',
        'tipe_transaksi',
        'kode_transaksi',
        'stok',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'tanggal_transaksi',
        'created_at',
        'updated_at',
    ];

    public function dataAsset(): BelongsTo
    {
        return $this->belongsTo(Assets::class, 'asset_id')->with('dataStatus', 'dataKondisi', 'dataLokasi');
    }

    public function dataUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->with('dataRole');
    }
}
