<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['name', 'phone_number', 'email', 'city', 'address', 'role', 'user_id', 'client_id', 'status', 'slug'];

    /**
     * undocumented function.
     *
     * @author
     **/
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
