<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test;

use ArrayAccess;
use PHPUnit\Util\InvalidArgumentHelper;
use PHPUnit\Framework\TestCase as PHPUnit;
use PubPeerFoundation\PublicationDataExtractor\Schema;

abstract class TestCase extends PHPUnit
{
    public static function assertArrayIsValid($array)
    {
        if (! (\is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array or ArrayAccess'
            );
        }

        $result = Schema::validate($array);

        static::assertThat($result->isValid(), static::isTrue(), (string) $result->getErrorMessage());
    }
}
