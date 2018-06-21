<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use Volan\Volan;

class ApiDataChecker
{
    /**
     * Array validation schema.
     */
    const SCHEMA = [
        'root' => [
            '_source' => [
                '_type' => 'string',
            ],
            'authors' => [
                '_type' => 'nested_array',
                'first_name' => [
                    '_type' => 'string',
                ],
                'last_name' => [
                    '_type' => 'required_string',
                ],
                'orcid' => [
                    '_type' => 'string',
                ],
                'email' => [
                    '_type' => 'string',
                ],
                'affiliation' => [
                    '_type' => 'array',
                    'name' => [
                        '_type' => 'string',
                    ],
                ],
            ],
            'identifiers' => [
                '_type' => 'nested_array',
                'value' => [
                    '_type' => 'required_string',
                ],
                'type' => [
                    '_type' => 'required_string',
                ],
            ],
            'journal' => [
                '_type' => 'array',
                'title' => [
                    '_type' => 'string',
                ],
                'issn' => [
                    '_type' => 'array',
                ],
                'publisher' => [
                    '_type' => 'string',
                ],
            ],
            'publication' => [
                '_type' => 'array',
                'title' => [
                    '_type' => 'required_string',
                ],
                'abstract' => [
                    '_type' => 'string',
                ],
                'url' => [
                    '_type' => 'required_string',
                ],
                'published_at' => [
                    '_type' => 'string',
                ],
            ],
            'types' =>  [
                '_type' => 'nested_array',
                'name' => [
                    '_type' => 'string',
                ],
            ],
            'tags' => [
                '_type' => 'nested_array',
                'name' => [
                    '_type' => 'string',
                ],
            ],
            'affiliations' => [
                '_type' => 'nested_array',
                'name' => [
                    '_type' => 'string',
                ],
            ],
            'updates' => [
                '_type' => 'array',
                'timestamp' => [
                    '_type' => 'string',
                ],
                'identifier' => [
                    '_type' => 'array',
                    'doi' => [
                        '_type' => 'string',
                    ],
                ],
                'type' => [
                    '_type' => 'string',
                ],
            ],
        ],
    ];

    /**
     * @param $data
     * @return \Volan\ValidatorResult
     */
    public static function check($data)
    {
        $validator = new Volan(static::SCHEMA);
        $result = $validator->validate($data);

        return $result;
    }

    public static function getDataTypes()
    {
        return array_slice(array_keys(ApiDataChecker::SCHEMA['root']), 1);
    }
}
