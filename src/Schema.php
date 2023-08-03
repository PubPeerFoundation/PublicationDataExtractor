<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use Volan\ValidatorResult;
use Volan\Volan;

class Schema
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
                'sequence' => [
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
                '_type' => 'required_array',
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
                '_type' => 'required_array',
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
            'links' => [
                '_type' => 'nested_array',
                'has_preprint' => [
                    '_type' => 'string',
                ],
                'is_preprint_of' => [
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
                '_type' => 'nested_array',
                'timestamp' => [
                    '_type' => 'required_number',
                ],
                'identifier' => [
                    '_type' => 'required_array',
                    'doi' => [
                        '_type' => 'string',
                    ],
                    'pubmed' => [
                        '_type' => 'string',
                    ],
                ],
                'type' => [
                    '_type' => 'required_string',
                ],
            ],
        ],
    ];

    /**
     * Validate the data against Schema.
     *
     * @param  $data
     */
    public static function validate($data): ValidatorResult
    {
        $validator = new Volan(static::SCHEMA);
        $result = $validator->validate($data);

        return $result;
    }

    /**
     * Get the main data types from Schema.
     */
    public static function getDataTypes(): array
    {
        return array_slice(array_keys(self::SCHEMA['root']), 1);
    }
}
