<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * undocumented class variable.
     *
     * @var string
     **/
    protected $fillable = ['ref_number', 'customer_name', 'amount', 'discount', 'tax', 'created_by'];
}
