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
     * @param  mixed $default
     * @return mixed
     */
    function get_string($array, $key, $default = null)
    {
        return stringify(data_get($array, $key, $default));
    }
}

if (! function_exists('get_array')) {
    /**
     * Get array from dot access key.
     *
     * @param mixed $target
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
        if (empty($data)) {
            return '';
        }

        if (is_array($data)) {
            return stringify($data[0]);
        }

        return (string) trim($data);
    }
}

if (! function_exists('find_emails_in_array')) {
    /**
     * Find emails in array.
     *
     * @param  array $array
     * @return array
     */
    function find_emails_in_array($array)
    {
        $pattern = '/(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))/iD';

        preg_match_all($pattern, implode(' ', $array), $matches);

        return $matches[0];
    }
}
