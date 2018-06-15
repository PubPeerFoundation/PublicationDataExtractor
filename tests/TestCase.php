<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test;

use ArrayAccess;
use PHPUnit\Framework\TestCase as PHPUnit;
use PHPUnit\Util\InvalidArgumentHelper;
use PubPeerFoundation\PublicationDataExtractor\ApiDataChecker;

abstract class TestCase extends PHPUnit
{
    public static function assertArrayIsValid($array)
    {
        if (!(\is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array or ArrayAccess'
            );
        }

        $result = ApiDataChecker::check($array);

        static::assertThat($result->isValid(), static::isTrue(), $result->getErrorMessage());
    }
}
