<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Whitelisted Database fields.
     *
     * @var array
     **/
    protected $fillable = ['name', 'address_line1', 'address_line2', 'city', 'zip_code', 'email', 'phone_number', 'street', 'state'];

    /**
     * Purchase Order Delivery address.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
