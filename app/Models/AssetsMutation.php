<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsMutation extends Model
{
    use HasFactory;

    protected $table = "mutasi_aset";

    protected $fillable = [
        'tipe_mutasi',
        'id_user',
        'id_asset',
        'created_at',
        'updated_at',
    ];
}
