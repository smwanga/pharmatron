<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['supplier_name', 'supplier_email', 'supplier_website', 'supplier_phone', 'supplier_address', 'city', 'notes', 'logo', 'currency_id', 'primary_contact'];

    /**
     * Contact people for the supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author
     **/
    public function contacts()
    {
        return $this->hasMany(Person::class, 'client_id');
    }

    /**
     * Fetch supplier invoices and orders.
     *
     * @author
     **/
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get purchase orders for a particular supplier.
     *
     * @return \Illuminate\Database\Collection
     **/
    public function orders()
    {
        $this->invoices()->where('type', 'LPO')->get();
    }
}
