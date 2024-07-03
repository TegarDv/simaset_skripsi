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
        'created_at',
        'updated_at',
    ];
}
