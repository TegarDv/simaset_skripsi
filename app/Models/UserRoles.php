<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;
    protected $table = "users_role";

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];
}
