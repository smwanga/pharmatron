<?php

namespace App\Repositories;

use Closure;

abstract class BaseRepository
{
    /**
     * Eloquent Model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     **/
    protected $model;

    /**
     * Get a collection of entities.
     *
     * @param Closure $callback
     *
     * @return Illuminate\Database\Collection
     **/
    public function all(Closure $callback = null)
    {
        $query = $this->model->newQuery();
        if (is_callable($callback)) {
            $query = $callback($query);
        }

        return $query->get();
    }

    /**
     * Get the eloquent database model.
     *
     * @return Illuminate\Database\Eloquent\Model
     **/
    public function getModel()
    {
        return $this->model;
    }
}
