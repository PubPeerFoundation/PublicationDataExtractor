<?php

use Tightenco\Collect\Support\Arr;
use PubPeerFoundation\PublicationDataExtractor\Support\DateHelper;

if (! function_exists('get_class_name')) {
    /**
     * @param $object
     * @return string
     */
    function get_class_name($object)
    {
        $className = get_class($object);
        $pos = strrpos($className, '\\');

        return substr($className, $pos + 1);
    }
}

if (! function_exists('date_from_parts')) {
    /**
     * Get Carbon Date Object from parts.
     *
     * @param  array $array
     * @return mixed
     */
    function date_from_parts($array)
    {
        return DateHelper::dateFromDateParts($array);
    }
}

if (! function_exists('date_from_pub_date')) {
    /**
     * Get Carbon Date Object from pub_date.
     *
     * @param  $object
     * @return mixed
     */
    function date_from_pub_date($object)
    {
        return DateHelper::dateFromPubDate($object);
    }
}

if (! function_exists('date_from_parseable_format')) {
    /**
     * Get Carbon Date Object from parseable string.
     *
     * @param  string $string
     * @return mixed
     */
    function date_from_parseable_format($string)
    {
        return DateHelper::dateFromParseableFormat($string);
    }
}

if (! function_exists('get_string')) {
    /**
     * Get string from array path.
     *
     * @param array $array
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    function get_string($array, $key, $default = null)
    {
        return stringify(data_get($array, $key, $default));
    }
}

if (! function_exists('get_array')) {
    /**
     * Get array from array path.
     *
     * @param array $target
     * @param $key
     * @param  array $default
     * @return array
     */
    function get_array($target, $key, $default = [])
    {
        $target = is_array($target) ? array_filter($target) : $target;

        return Arr::wrap(data_get($target, $key, $default));
    }
}

if (! function_exists('stringify')) {
    /**
     * Convert entry to string.
     *
     * @param  mixed  $data
     * @return string
     */
    function stringify($data)
    {
        if (is_array($data)) {
            return stringify($data[0]);
        }

        return (string) trim($data);
    }
}
