<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['qty', 'sale_d', 'product_id', 'unit_cost', 'instructions'];
}
