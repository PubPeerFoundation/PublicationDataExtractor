<?php

namespace PubPeerFoundation\PublicationDataExtractor;

class ApiDataMerger
{
    /**
     * @param  array $data
     * @return array
     */
    public static function handle(array $data)
    {
        return self::mergeData($data);
    }

    /**
     * @param $data
     * @return array
     */
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
