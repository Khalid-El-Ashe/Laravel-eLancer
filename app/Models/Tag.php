<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false; //todo we delete the timestamps from table

    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * need make a new relation
     * MANY - TO - MANY relation
     */
    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            // 'project_tag',
            // 'tag_id',
            // 'project_id',
            // 'id',
            // 'id'
        );
    }
}
