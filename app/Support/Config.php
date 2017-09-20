<?php

namespace App\Support;

use Illuminate\Support\Collection;

class Config
{
    /**
     * The underlying object.
     *
     * @var mixed
     */
    protected $config;

    /**
     * Create a new optional instance.
     *
     * @param mixed $config
     */
    public function __construct(Collection $config)
    {
        $this->config = $config;
    }

    /**
     * Dynamically access a property on the underlying object.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if (is_object($this->config)) {
            $value = $this->config->where('key', $key)->first();

            return $value ? $value->value : null;
        }
    }
}
