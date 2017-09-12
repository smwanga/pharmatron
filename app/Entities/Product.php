<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['generic_name', 'stock_code', 'alert_level', 'barcode', 'category_id', 'unit', 'instructions', 'description', 'notes'];

    /**
     * Return the product category relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product stock.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Return the product's dispensing unit relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dispenseUnit()
    {
        return $this->belongsTo(Category::class, 'unit');
    }

    /**
     * Return the product's dispensing unit.
     *
     * @return string
     **/
    protected function getDispensingUnitAttribute()
    {
        return $this->dispenseUnit->category;
    }

    /**
     * Return the threshold stock available.
     *
     * @return int
     **/
    protected function getAvailableStockAttribute()
    {
        return $this->stock()->available()->sum('stock_available');
    }

    /**
     * Return the value of available stock.
     *
     * @return int
     **/
    protected function getStockValueAttribute()
    {
        // determine if there  is available stock
        //
        $available = $this->stock()->available();

        return $available->count() ? $available->stockValue() : 0;
    }

    /**
     * Return the available stock for sale.
     *
     * @return Stock
     **/
    protected function getForSaleAttribute()
    {
        return $this->stock()->available()->first();
    }
}
