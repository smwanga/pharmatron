<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Whitelisted database columns.
     *
     * @var array
     */
    protected $fillable = ['company_name', 'city', 'email', 'website', 'phone_number', 'notes', 'address'];

    /**
     * Invoices relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function invoices()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * People relation for a company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
