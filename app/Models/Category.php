<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'art_path',
        'parent_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * now i need to make a relation
     * ONE - TO - MANY for project
     */
    public function project()
    {
        return $this->hasMany(Project::class, 'category_id', 'id');
    }

    /**
     * i need make another relation that is from category to category(parent_id)
     *
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     *
     * علاقة عكسة لنفس الجدول
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'no parent'
        ]); //todo the function withDefault() -> is using with relation belongsTo and hasOne
    }
}
