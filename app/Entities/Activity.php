<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['user_id', 'details', 'icon', 'url', 'type', 'action'];

    /**
     * User relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
