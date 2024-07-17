<?php

namespace App\Models;

use App\Models\Assets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionRequest extends Model
{
    use HasFactory;

    protected $table = "request_peminjaman_aset";

    protected $fillable = [
        'asset_id',
        'user_id',
        'jumlah',
        'keterangan',
        'tanggal_permintaan',
        'status_permintaan',
        'catatan_permintaan',
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
