<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    /**
     * Whitelisted database fields.
     *
     * @var array
     **/
    protected $fillable = ['key', 'value'];
}
