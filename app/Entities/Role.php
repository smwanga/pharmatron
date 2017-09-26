<?php

namespace App\Entities;

use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{
    /**
     * undocumented function.
     *
     * @author
     **/
    public function hasAbility($ability)
    {
        return $this->abilities()->where('name', $ability)->first() !== null;
    }
}
