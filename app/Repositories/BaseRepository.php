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
     * Eloquent query builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     **/
    protected $query;

    /**
     * Get a collection of entities.
     *
     * @param Closure $callback
     *
     * @return Illuminate\Database\Collection
     **/
    public function all(Closure $callback = null)
    {
        return $this->runCallback($callback)->get();
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

    /**
     * Get the results of a query.
     *
     * @param Closure $callback
     **/
    protected function runCallback(Closure $callback = null)
    {
        if (is_callable($callback)) {
            $this->model = $callback($this->model);
        }

        return $this->model;
    }

    /**
     * Find entity by field and return the first result.
     *
     * @param string $field
     * @param mixed  $value
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\ModelNotFoundException
     **/
    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->firstOrFail();
    }
}
