<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * now i need add the relation is contact with Freelancer Table
     * The User is Has One FreelancerProfile(Freelancer)
     * ONE - TO - ONE Relation
     */
    public function freelancer()
    {
        //todo the secound parameter is Optional The Laravel now what the column when the Model Class Added
        return $this->hasOne(Freelancer::class, 'user_id', 'id')->withDefault();
    }

    /**
     * now i need add the relation is contact with Project Table
     * The User is Has Many Projects
     * ONE - TO - MANY Relation
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    /**
     * need make a accessor to get the User Profile Photo
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->freelancer->profile_photo == null) {
            return asset('storage/' . $this->freelancer->profile_photo_path);
        }
        return asset('images/default.png');
    }

    public function getNameAttribute($value)
    {
        // this function to make the first letter uppercase
        // return ucfirst($value);
        return Str::title($value);
    }

    /**
     * Motator => this function to make the email lowercase when store in database
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Str::lower($value); // make the email lowercase
    }

    /**
     * Summary of proposals
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'freelancer_id', 'id');
    }

    /**
     * related model MANY-TO-MANY
     */
    public function proposedProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'proposals',
            'freelancer_id',
            'project_id'
        )->withPivot([
            'description',
            'cost',
            'duration',
            'duration_unit',
            'status'
        ]);
    }
    /**
     * related model MANY-TO-MANY
     */
    public function contractedProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'contracts',
            'freelancer_id',
            'project_id'
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
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'freelancer_id', 'id');
    }

    public function routeNotificationForEmail($notification = null)
    {
        return $this->email;
    }
}
