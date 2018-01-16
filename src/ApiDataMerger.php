<?php

namespace PubPeerFoundation\PublicationDataExtractor;

class ApiDataMerger
{
    public static function handle(ApiDataFetcher $dataFetcher)
    {
        return self::mergeData($dataFetcher->apiData);
    }

    protected static function mergeData($data)
    {
        $tmp = [];
        foreach($data as $resourceData) {
            foreach($resourceData as $key => $value) {
                $tmp[$key][] = $value;
            }
        }

        return $tmp;
    }
}
