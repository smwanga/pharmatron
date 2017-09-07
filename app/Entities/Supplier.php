<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['supplier_name', 'supplier_email', 'supplier_website', 'supplier_phone', 'supplier_address', 'city', 'notes', 'logo', 'currency_id', 'primary_contact'];
}
