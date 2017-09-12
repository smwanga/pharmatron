<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'customer_name', 'amount', 'discount', 'tax', 'created_by', 'status', 'type'];

    /**
     * Hook into the model bootstraper and atach event listeners.
     *
     * @author
     **/
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sale) {
            $sale->ref_number = static::saleUUID();
            // $sale->created_by = auth()->user()->id;
        });
    }

    /**
     * Sale items relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    private static function saleUUID($entropy = false)
    {
        $s = uniqid('', $entropy);
        if (!$entropy) {
            return mb_strtoupper(base_convert($s, 16, 36));
        }
        $hex = substr($s, 0, 13);
        $dec = $s[13].substr($s, 15); // skip the dot
        return mb_strtoupper(base_convert($hex, 16, 36).base_convert($dec, 10, 36));
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getTotalAttribute()
    {
        return (int) $this->items->map(function ($item) {
            return $item->qty * $item->unit_cost;
        })->sum();
    }
}
