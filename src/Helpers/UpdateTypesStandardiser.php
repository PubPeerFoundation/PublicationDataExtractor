<?php

namespace XavRsl\PublicationDataExtractor\Helpers;

class UpdateTypesStandardiser
{
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
        'expression_of_concern' => 'Expression of concern',
        'expression-of-concern' => 'Expression of concern',
        'note-discuss' => 'Note',
        'publisher-note' => 'Note',
        'removal' => 'Retracted',
        'retraction' => 'Retracted',
        'Retraction' => 'Retracted',
        'retration' => 'Retracted',
        'withdrawal' => 'Withdrawn',
    ];

    public static function getType($type)
    {
        return self::TYPES_MAP[$type];
    }
}
