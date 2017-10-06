<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['ref_number', 'customer_name', 'amount', 'discount', 'tax', 'created_by', 'status', 'type', 'customer_id'];

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
            $sale->created_by = auth()->user()->id;
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
     * Generate a unique sale uuid.
     *
     * @return string
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
     * Get the toal amount after all deductions are made.
     *
     * @return float
     **/
    protected function getTotalAttribute()
    {
        return (int) (($this->sub_total + $this->tax_amount) - $this->discount_amount);
    }

    /**
     * Get the taxable amount for this sale.
     *
     * @return float
     **/
    protected function getTaxAmountAttribute()
    {
        return $this->sub_total * $this->tax / 100;
    }

    /**
     * Get the sale discount amount after taxes are applied.
     *
     * @return float
     **/
    protected function getDiscountAmountAttribute()
    {
        return ($this->sub_total + $this->tax_amount) * $this->discount / 100;
    }

    /**
     * Get the sub total amount before taxes and discounts are applied.
     *
     * @return float
     **/
    protected function getSubTotalAttribute()
    {
        return $this->items->map(function ($item) {
            return $item->qty * $item->unit_cost;
        })->sum();
    }

    /**
     * Get the total due Amount for a sale.
     *
     * @return float
     **/
    protected function getDueAttribute()
    {
        return $this->total - $this->paid;
    }

    /**
     * Get the total amount paid for a sold item.
     *
     * @return float
     **/
    protected function getPaidAttribute()
    {
        return $this->payments()->sum('amount');
    }

    /**
     * Get payments relation to a sale.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the user relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Company relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Customer relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function getMetaAttribute()
    {
        if ($this->type == 'invoice') {
            return ['class' => 'success', 'text' => trans('main.sale')];
        }

        return ['class' => 'warning', 'text' => trans('main.draft')];
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function scopeTotal($query)
    {
        return $query->count() ? $query->get()->map(function ($sale) {
            return $sale->total;
        })->sum() : 0;
    }
}
