<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LogUsers extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "log_activity";

    protected $fillable = [
        'id_user',
        'action',
        'detail',
        'status',
        'created_at',
        'updated_at',
    ];

    public function data_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
