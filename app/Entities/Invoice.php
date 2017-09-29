<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $casts = [
        'invoiced' => 'boolean',
    ];
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['supplier_id', 'due_after', 'notes', 'address_id', 'currency_id', 'delivery_date', 'invoiced', 'lpo_number', 'type'];

    /**
     * Date motators.
     *
     * @var array
     **/
    protected $dates = ['due_after', 'delivery_date'];

    /**
     * undocumented function.
     *
     * @author
     **/
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            switch ($model->attributes['type']) {
                case 'LPO':
                    $ref = tr_code(app_config('lpo_prefix'));
                    break;

                case 'Invoice':
                    $ref = tr_code(app_config('inv_prefix'));
                    break;

                case 'Estimate':
                    $ref = tr_code(app_config('est_prefix'));
                    break;

                default:
                    $ref = tr_code();
                    break;
            }
            $model->reference_no = $ref;
            $model->created_by = auth()->user()->id;
        });
    }

    /**
     * InvoiceItem relation.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Purchase Order Items .
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lpoItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Delivery Address for a purchase order.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Supplier for a purchase order.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
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
    protected function getLpoTotalAttribute()
    {
        return $this->lpoItems()->total();
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Product relation.
     *
     * @return Product
     **/
    public function invoice()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * Get the sub total amount before taxes and discounts are applied.
     *
     * @return float
     **/
    protected function getTotalAttribute()
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
}
