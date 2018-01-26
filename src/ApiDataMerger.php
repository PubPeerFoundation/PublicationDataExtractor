<?php

namespace PubPeerFoundation\PublicationDataExtractor;

class ApiDataMerger
{
    public static function handle(array $data)
    {
        return self::mergeData($data);
    }

    protected static function mergeData($data)
    {
        $tmp = [];
        foreach ($data as $resourceData) {
            foreach ($resourceData as $key => $value) {
                $tmp[$key][] = $value;
            }
        }

        return $tmp;
    }
}
