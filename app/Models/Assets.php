<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\DataStatus;

class Assets extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "assets";

    protected $fillable = [
        'id_user',
        'tipe_aset',
        'kode_aset',
        'nama_aset',
        'jumlah',
        'harga',
        'spesifikasi',
        'keterangan',
        'status',
        'kondisi_aset',
        'masa_berlaku',
        'created_at',
        'updated_at',
    ];

    public function dataStatus(): BelongsTo
    {
        return $this->belongsTo(DataStatus::class, 'status')->where('status', '1');
    }

    public function getStatusNamaAttribute(): string
    {
        return $this->dataStatus->nama_status ?? '';
    }
}
