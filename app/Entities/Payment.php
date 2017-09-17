<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    /**
     * Hook into the model bootstraper and atach event listeners.
     *
     * @author
     **/
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            $payment->tr_code = static::trCode(true);
            $payment->authorized_by = auth()->user()->id;
        });
    }

    /**
     * Generate a unique transaction number.
     *
     * @return string
     **/
    private static function trCode($entropy = false)
    {
        $s = uniqid('', $entropy);
        if (!$entropy) {
            return mb_strtoupper(base_convert($s, 16, 36));
        }
        $hex = substr($s, 0, 13);
        $dec = $s[13].substr($s, 15); // skip the dot
        return mb_strtoupper(base_convert($hex, 16, 36).base_convert($dec, 10, 36));
    }
}
