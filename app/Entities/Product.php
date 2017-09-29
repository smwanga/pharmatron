<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['generic_name', 'item_name', 'stock_code', 'alert_level', 'barcode', 'category_id', 'unit', 'instructions', 'description'];

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
     * Sales Relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sales()
    {
        return $this->hasMany(SaleItem::class);
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

    /**
     * Decrement the stock by the specified items.
     *
     * @param int $items
     *
     * @return bool
     **/
    public function sell(int $items)
    {
        if ($this->available_stock < $items) {
            return false;
        }
        $first = $this->for_sale;
        if ($first->stock_available >= $items) {
            $new_level = $first->stock_available - $items;
            Stock::where('id', $first->id)->update(['stock_available' => $new_level]);

            return $new_level;
        } else {
            while ($items > 0) {
                $for_sale = $this->getForSaleAttribute();
                $new_level = 0;
                if ($for_sale->stock_available <= $items) {
                    $items = $items - $for_sale->stock_available;
                    Stock::where('id', $for_sale->id)->update(['stock_available' => $new_level]);
                } else {
                    $new_level = $for_sale->stock_available - $items;
                    Stock::where('id', $for_sale->id)->update(['stock_available' => $new_level]);
                    $items = 0;
                }
            }

            return $new_level;
        }
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getGenericNameAttribute()
    {
        return $this->attributes['generic_name'] ?: $this->attributes['item_name'];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function scopeMonthlySales($query, $month)
    {
        return $this->sales()->whereMonth('created_at', $month);
    }

    /**
     * Get product movement..
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function stockMovement()
    {
        return $this->hasMany(Inventory::class);
    }
}
