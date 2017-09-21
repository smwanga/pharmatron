<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['qty', 'invoice_id', 'product_id', 'unit_cost', 'instructions'];

    /**
     * Product relation.
     *
     * @return Product
     **/
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
