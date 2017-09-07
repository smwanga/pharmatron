<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Stock extends Model
{
    /**
     * Whitelisted database fields.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'lpo_number', 'description', 'pack_size', 'invoice_id', 'qty', 'marked_price', 'selling_price', 'batch_no', 'expire_at', 'supplier_id', 'product_id'];

    protected $casts = [
        'expire_at' => 'date',
    ];

    /**
     * undocumented function.
     *
     * @param
     **/
    protected function setEpireAtAttribute($epiry_date)
    {
        $this->attributes['expire_at'] = Carbon::parse($expiry_date);
    }

    /**
     * Return stock that is not expired and is set as active.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeAvailable(Builder $query)
    {
        return $query->whereDate('expire_at', '>', Carbon::now())->where('active', true)->orderBy('expire_at', 'ASC');
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
}
