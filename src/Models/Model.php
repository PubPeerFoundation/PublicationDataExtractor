<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

use Exception;
use Tightenco\Collect\Support\Arr;

class Model
{
    /**
     * This var should never be used, in favor of Model's internal var.
     *
     * @var array
     */
    protected $list = [];

    /**
     * List of statically created instances.
     *
     * @var array
     */
    private static $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize singleton');
    }

    /**
     * Return the current Model's instance.
     *
     * @return Model
     */
    public static function getInstance()
    {
        $cls = get_called_class();
        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Figure out which values are already known.
     *
     * @param $key
     * @return array
     */
    protected function knownIdentifierValues($key): array
    {
        return array_map(function ($value) {
            return strtolower($value);
        }, Arr::pluck($this->list, $key));
    }

    /**
     * Should the attribute be kept?
     *
     * @param $key
     * @param $value
     * @return bool
     */
    protected function shouldKeepAttribute($key, $value): bool
    {
        $function = is_array($value) ? 'count' : 'strlen';

        if (! isset($this->list[$key])) {
            return true;
        }

        return $function($this->list[$key]) > $function($value);
    }

    protected function reset()
    {
        $this->list = [];
    }
}
