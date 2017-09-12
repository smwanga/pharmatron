<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Stock extends Model
{
    /**
     * Hook into the model bootstraper and atach event listeners.
     *
     * @author
     **/
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->attributes['stock_available'] = $model->attributes['pack_size'] * $model->attributes['qty'];
        });
    }

    /**
     * Whitelisted database fields.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'lpo_number', 'description', 'pack_size', 'invoice_id', 'qty', 'marked_price', 'selling_price', 'batch_no', 'expire_at', 'supplier_id', 'product_id', 'stock_available'];

    protected $dates = ['expire_at'];

    /**
     * Return stock that is not expired and is set as active.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeAvailable(Builder $query)
    {
        return $query->whereDate('expire_at', '>', Carbon::now())->where('active', true)->orderBy('expire_at', 'ASC')->where('stock_available', '>', 0);
    }

    /**
     * Return stock that is not expired and is set as active.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeStockValue(Builder $query)
    {
        return $query->get()->map(function ($stock, $key) {
            return $stock->stock_value = $stock->selling_price * $stock->stock_available;
        })->get('0');
    }

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
