<?php

namespace PubPeerFoundation\PublicationDataExtractor\Helpers;

class ClassHelper
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
}
