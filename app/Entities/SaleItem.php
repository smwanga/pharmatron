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
    protected $fillable = ['qty', 'sale_id', 'product_id', 'unit_cost', 'instructions'];

    /**
     * Product relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the sales invoice.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
