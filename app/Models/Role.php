<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abilities'
    ];

    # casting from json TO array in Database
    protected $casts = [
        'abilities' => 'array'
    ];

    # need make relation MANY-TO-MANY
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
