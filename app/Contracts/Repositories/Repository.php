<?php

namespace App\Contracts\Repositories;

use Closure;

interface Repository
{
    /**
     * Create an entity in the database.
     *
     * @param array $attributes Fields to be populated
     **/
    public function create(array $attributes);

    /**
     * Get a collection of entities.
     *
     * @param Closure $callback Pass an additional query callback
     **/
    public function all(Closure $callback = null);
}
