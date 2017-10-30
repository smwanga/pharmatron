<?php

namespace App\Entities;

use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{
    /**
     * Determin if a role has an ability.
     *
     * @return bool
     **/
    public function hasAbility($ability)
    {
        return $this->abilities()->where('name', $ability)->first() !== null;
    }
}
