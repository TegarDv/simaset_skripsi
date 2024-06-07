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
        'tipe_aset',
        'kode_aset',
        'nama_aset',
        'jumlah',
        'harga',
        'spesifikasi',
        'keterangan',
        'stok_awal',
        'stok_sekarang',
        'masa_berlaku',
        'tanggal_penerimaan',
        'status_aset',
        'kondisi_aset',
        'lokasi_aset',
        'pemilik_aset',
        'created_at',
        'updated_at',
    ];

    public function dataStatus(): BelongsTo
    {
        return $this->belongsTo(DataStatus::class, 'status_aset')->where('status', '1');
    }

    public function getStatusNamaAttribute(): string
    {
        return $this->dataStatus->nama_status ?? '';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->dataStatus->color ?? 'secondary';
    }
}
