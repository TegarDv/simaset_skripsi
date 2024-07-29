<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DataStatus extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "data_status";

    protected $fillable = [
        'nama_status',
        'color',
        'kategori',
        'biaya_perbaikan',
        'created_at',
        'updated_at',
    ];

    public static $rules = [
        'biaya_perbaikan' => 'required|numeric|min:0|max:1',
    ];
}
