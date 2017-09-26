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
        static::creating(function ($model) {
            $model->attributes['stock_available'] = $model->attributes['pack_size'] * $model->attributes['qty'];
        });
    }

    /**
     * Whitelisted database fields.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'lpo_number', 'description', 'pack_size', 'qty', 'marked_price', 'selling_price', 'batch_no', 'expire_at', 'supplier_id', 'product_id', 'stock_available'];

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
            return $stock->selling_price * $stock->stock_available;
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

    /**
     * Supplier relation.
     *
     * @return Supplier
     **/
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getStatusAttribute()
    {
        if ($this->expire_at->isPast() and $this->active) {
            return ['class' => 'danger', 'text' => trans('main.expired')];
        } elseif ($this->available()->count() > 0 and $this->active) {
            return ['class' => 'success', 'text' => trans('main.available')];
        } elseif (!$this->active) {
            return ['class' => 'warning', 'text' => trans('main.inactive')];
        }

        return ['class' => 'info', 'text' => trans('main.uknown')];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getExpiryAttribute()
    {
        return $this->expire_at->format('Y-m-d');
    }

    public function scopeExpired($query)
    {
        return $query->active()->where('expire_at', '<', Carbon::now());
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOutOfStock($query)
    {
        return $query->active()->where('stock_available', 0);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getIsAvailableAttribute()
    {
        return $this->active && $this->stock_available > 0 && !$this->is_expired;
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getIsInactiveAttribute()
    {
        return !$this->active && $this->stock_available > 0 && !$this->is_expired;
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getIsExpiredAttribute()
    {
        return Carbon::parse($this->expire_at)->isPast();
    }

    /**
     * @author
     **/
    public function getStockValueAttribute()
    {
        return $this->attributes['selling_price'] * $this->attributes['stock_available'];
    }
}
