<?php

namespace PubPeerFoundation\PublicationDataExtractor\Helpers;

class Helpers
{
    /**
     * @param $object
     * @return string
     */
    public static function get_class_name($object)
    {
        $className = get_class($object);
        $pos = strrpos($className, '\\');

        return substr($className, $pos + 1);
    }

    /**
     * @param mixed  $entry
     * @return string
     */
    public static function flatten($entry)
    {
        return is_array($entry) ? $entry[0] : $entry;
    }
}
