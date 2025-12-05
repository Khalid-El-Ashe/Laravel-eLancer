<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'status',
        'type',
        'budget',
    ];

    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';

    /**
     * i need to create the Relations with User Model
     * This table is Following the User Model (belongsTo())
     * ONE - TO - MANY Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function types()
    {
        return [
            self::TYPE_FIXED => 'Fixed',
            self::TYPE_HOURLY => 'Hourly'
        ];
    }

    /**
     * now i need to make a relation
     * ONE - TO - MANY for categories
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
