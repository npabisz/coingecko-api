<?php

namespace CoinGecko\Resources;

use CoinGecko\Client;

/*
    Base Resource Class
    Abstract class that handles different requests type for API
*/

abstract class BaseResource
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $changedData;

    /**
     * @param string $name
     * @param mixed $default
     * @param bool $cast
     *
     * @return mixed
     */
    public function getData ($name = null, $default = null)
    {
        $data = is_array($this->data) ? array_merge($this->data, $this->changedData) : $this->data;

        if (null === $name) {
            return $data;
        }

        if (!isset($data[$name])) {
            return $default;
        }

        $method = $this->toCamelCase('get_' . $name . '_attribute');

        if (method_exists($this, $method)) {
            return $this->{$method}($data[$name]);
        }

        return $data[$name];
    }
}
