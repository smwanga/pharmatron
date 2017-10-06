<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['name', 'phone_number', 'email', 'city', 'address', 'role', 'user_id', 'client_id', 'status', 'slug', 'company_id'];

    /**
     * undocumented function.
     *
     * @author
     **/
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Company relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Invoices for a users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function invoices()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }
}
