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
            $bp = $model->attributes['marked_price'];
            if ($model->attributes['discount'] > 0) {
                $bp = $model->attributes['marked_price'] - ($model->attributes['marked_price'] * 100 / $model->attributes['discount']);
            }
            $model->attributes['buying_price'] = $bp;
            $model->attributes['stock_available'] = $model->attributes['pack_size'] * $model->attributes['qty'];
        });
    }

    /**
     * Whitelisted database fields.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'lpo_number', 'description', 'pack_size', 'qty', 'marked_price', 'selling_price', 'batch_no', 'expire_at', 'supplier_id', 'product_id', 'stock_available', 'buying_price', 'discount'];

    protected $dates = ['expire_at'];

    /**
     * Return stock that is not expired and is set as active.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeAvailable(Builder $query)
    {
        return $query->whereDate('expire_at', '>', Carbon::now())
                ->where('active', true)
                ->where(function ($query) {
                    return $query->where('stock_available', '>', 0);
                })
                ->orderBy('expire_at', 'ASC');
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
     * Get the status of the stock item.
     *
     * @return array
     **/
    protected function getStatusAttribute()
    {
        if ($this->expire_at->isPast() and $this->active) {
            return ['class' => 'danger', 'text' => trans('main.expired')];
        } elseif ($this->stock_available > 0 and $this->active) {
            return ['class' => 'success', 'text' => trans('main.available')];
        } elseif (!$this->active) {
            return ['class' => 'warning', 'text' => trans('main.inactive')];
        } elseif ($this->stock_available == 0 and $this->active) {
            return ['class' => 'danger', 'text' => trans('main.low_stock')];
        }

        return ['class' => 'info', 'text' => trans('main.uknown')];
    }

    /**
     * Get the expiry date attribute in Y-m-d format.
     *
     * @author
     **/
    protected function getExpiryAttribute()
    {
        return $this->expire_at->format('Y-m-d');
    }

    /**
     * Get scope for expired stock.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
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
     * Determine if the stock item is avilable.
     *
     * @return bool
     **/
    protected function getIsAvailableAttribute()
    {
        return $this->active && $this->stock_available > 0 && !$this->is_expired;
    }

    /**
     * Determin if stock has been deactivated.
     *
     * @return bool
     **/
    protected function getIsInactiveAttribute()
    {
        return !$this->active && $this->stock_available > 0 && !$this->is_expired;
    }

    /**
     * Determine if a stock has expired.
     *
     * @author
     **/
    protected function getIsExpiredAttribute()
    {
        return Carbon::parse($this->expire_at)->isPast();
    }

    /**
     * Get the total stock value of the available stock.
     *
     * @return float
     **/
    public function getStockValueAttribute()
    {
        return $this->attributes['selling_price'] * $this->attributes['stock_available'];
    }

    /**
     * Get the total stock value of stock received this month.
     *
     * @return float
     **/
    public static function getThisMonth()
    {
        return static::where('created_at', 'like', date('Y-m-').'%')->sum('marked_price');
    }
}
