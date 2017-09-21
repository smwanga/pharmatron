<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['supplier_id', 'due_after', 'notes', 'address_id', 'currency_id', 'delivery_date'];

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
            switch ($model->type) {
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
            $model->ref_number = $ref;
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
}
