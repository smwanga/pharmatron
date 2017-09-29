<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * undocumented function.
     *
     * @author
     **/
    public function person()
    {
        return $this->hasOne(Entities\Person::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * User activity log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Hasmany
     **/
    public function activity()
    {
        return $this->hasMany(Entities\Activity::class);
    }

    /**
     * [userSales description].
     *
     * @param [type] $period [description]
     *
     * @return [type] [description]
     */
    public function userSalesToday()
    {
        return $this->sales()->whereType('invoice')->whereDate('created_at', Carbon::now()->format('Y-m-d'))->get();
    }

    /**
     * [userSales description].
     *
     * @param [type] $period [description]
     *
     * @return [type] [description]
     */
    public function userSalesThisMonth()
    {
        return $this->sales()->whereType('invoice')->where('created_at', 'like', Carbon::now()->format('Y-m').'%')->get();
    }

    /**
     * [userSales description].
     *
     * @param [type] $period [description]
     *
     * @return [type] [description]
     */
    public function userSalesThisYear()
    {
        return $this->sales()->whereType('invoice')->where('created_at', 'like', Carbon::now()->format('Y-m').'%')->get();
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function sales()
    {
        return $this->hasMany(Entities\Sale::class, 'created_by');
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    protected function getIsLoggedInAttribute()
    {
        return $this->id === auth()->user()->id;
    }
}
