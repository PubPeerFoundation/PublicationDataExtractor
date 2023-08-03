<?php

namespace PubPeerFoundation\PublicationDataExtractor\Support;

class UpdateTypesStandardiser
{
    /**
     * Array map of what should be replaced.
     */
    const TYPES_MAP = [
        'comment' => 'Comment',
        'corrected-article' => 'Corrected',
        'correction' => 'Corrected',
        'Correction' => 'Corrected',
        'correspondence' => 'Correspondence',
        'corrigendum' => 'Corrected',
        'Corrigendum' => 'Corrected',
        'err' => 'Erratum',
        'erratum' => 'Erratum',
        'Erratum' => 'Erratum',
        'ErratumIn' => 'Erratum',
        'expression_of_concern' => 'Expression of concern',
        'expression-of-concern' => 'Expression of concern',
        'ExpressionOfConcernIn' => 'Expression of concern',
        'note-discuss' => 'Note',
        'publisher-note' => 'Note',
        'removal' => 'Retracted',
        'retraction' => 'Retracted',
        'Retraction' => 'Retracted',
        'RetractionIn' => 'Retracted',
        'retration' => 'Retracted',
        'withdrawal' => 'Withdrawn',
        'new_version' => 'New Version',
    ];

    /**
     * @param  $type
     * @return mixed
     */
    public static function getType($type)
    {
        if (! isset(self::TYPES_MAP[$type])) {
            return $type;
        }

        return self::TYPES_MAP[$type];
    }
}
