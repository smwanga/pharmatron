<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The database table to use.
     *
     * @var string
     **/
    protected $table = 'inventory';

    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['created_by', 'comment', 'on_stock', 'qty', 'product_id', 'tr_type'];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
