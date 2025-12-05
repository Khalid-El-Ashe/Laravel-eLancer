<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    // must add the new primary key to the Model
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'country',
        'verified',
        'description',
        'hourly_rate',
        'profile_photo_path',
        'gender',
        'birth_date'
    ];
    /**
     * i need to create the Relations with User Model
     * This table is Following the User Model (belongsTo())
     * ONE - TO - ONE Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
