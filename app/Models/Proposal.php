<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Proposal extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'freelancer_id',
        'project_id',
        'description',
        'cost',
        'duration',
        'duration_unit',
        'status'
    ];

    /**
     * now i build the relation
     */
    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    /**
     * Summary of contract relation ONE-TO-ONE
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contract()
    {
        return $this->hasOne(Contract::class, 'proposal_id', 'id')->withDefault();
    }

    public static function units()
    {
        return [
            'day' => 'Day',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'Year'
        ];
    }
}
