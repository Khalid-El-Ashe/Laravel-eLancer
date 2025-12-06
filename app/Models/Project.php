<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'attachments'
    ];
    protected $casts = [
        'budget' => 'float',
        'attachments' => 'json'
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

    /**
     * now i need make a new relation
     * MANY - TO - MANY for tags
     */
    public function tags()
    {
        // $related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null, $relatedKey = null, $relation = null
        return $this->belongsToMany(
            Tag::class, // Related Model
            'project_tag', // Piveot Table
            'project_id', // F.K for current model in pivot table
            'tag_id', // F.K for related model in privot table
            'id', // current model key (p.k.)
            'id' // related model key (p.k. related model)
        );
    }

    public function syncTags(array $tags)
    {
        // now need to save tags
        $tags_id = [];
        foreach ($tags as $tag_name) {
            $tag = Tag::firstOrCreate([
                'slug' => Str::slug($tag_name)
            ], [
                'name' => trim($tag_name),  // to delete the spaces in the word
            ]);
            $tags_id[] = $tag->id;
        }
        $this->tags()->sync($tags_id);
    }
}
