<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['amount', 'tr_code', 'authorized_by', 'sale_id', 'invoice_id', 'notes', 'status'];

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

    /**
     * undocumented function.
     *
     * @author
     **/
    public static function getTodaySales()
    {
        return static::whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('status', 'Payment')->sum('amount');
    }

    public static function getSalesThisMonth()
    {
        return static::where('created_at', 'like', Carbon::now()->format('Y-m').'%')->where('status', 'Payment')->sum('amount');
    }

    public static function getSalesThisYear()
    {
        $data = [];
        for ($month = 1; $month <= 12; ++$month) {
            $date = date("Y-{$month}-01");
            $sales = static::where('created_at', 'like', Carbon::parse($date)->format('Y-m').'%')->where('status', 'Payment')->sum('amount');
            $data[] = ['period' => date("Y-{$month}"), 'income' => $sales];
        }

        return $data;
    }

    public static function getExpensesThisMonth()
    {
        return static::where('created_at', 'like', Carbon::now()->format('Y-m').'%')->where('status', 'Expense')->sum('amount');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function user()
    {
        return $this->belongsTo('App\User', 'authorized_by');
    }
}
