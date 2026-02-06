<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Summary of booted
     * Global Scope
     * is access outomatical when the controller is access
     */
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', '=', 'open');
        });
    }

    /**
     * Local Scope
     * is access when the developer/user access the controller/route
     */
    public function scopeClosed(Builder $builder)
    {
        $builder->where('status', '=', 'closed');
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeHourly(Builder $builder)
    {
        $builder->where('hourly', '=', 'hourly');
    }
    public function scopeFilter(Builder $builder, $filters = [])
    {
        $filters = array_merge(
            [
                'type' => null,
                'status' => null,
                'budget_min' => null,
                'budget_max' => null
            ],
            $filters
        );
        if ($filters['type']) {
            $builder->where('type', '=', $filters['type']);
        }

        // the function is access when the valueOf(type) is true
        $builder->when($filters['type'], function ($builder, $value) {
            $builder->where('status', '=', $value);
        });

        $builder->when($filters['budget_min'], function ($builder, $value) {
            $builder->where('budget', '>=', $value);
        });

        $builder->when($filters['budget_max'], function ($builder, $value) {
            $builder->where('budget', '<=', $value);
        });
    }
    public function scopeHighestBudget(Builder $build)
    {
        $build->orderBy('budget', 'DESC');
    }

    protected $casts = [
        'budget' => 'float',
        'attachments' => 'json'
    ];
    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';


    // i need hidden a column when using in json api
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // access the accessuer method or any data need
    protected $appends = [
        'type_name'
    ];

    /**
     * need make an accessuer method
     */
    public function getTypeNameAttribute()
    {
        //$project->type_name
        return ucfirst($this->type);
    }

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

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function proposedFreelancers()
    {
        return $this->belongsToMany(
            User::class,
            'proposals',
            'project_id',
            'freelancer_id',
        )->withPivot([
            'description',
            'cost',
            'duration',
            'duration_unit',
            'status'
        ]);
    }

    // Project -> Contract (project_id) -> Freelancer (contract_id) (User)
    public function contractedFreelancers()
    {
        return $this->belongsToMany(
            User::class,
            'contracts',
            'project_id',
            'freelancer_id',
        )->withPivot([
            'proposal_id',
            'cost',
            'type',
            'start_on',
            'end_on',
            'complete_on',
            'hours',
            'status'
        ]);
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

    public function toJson($option = 0)
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->title
        ]);
    }
}
