<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test;

use ArrayAccess;
use PHPUnit\Util\InvalidArgumentHelper;
use PHPUnit\Framework\TestCase as PHPUnit;
use PHPUnit\Framework\Constraint\ArraySubset;
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

    /**
     * Asserts that an array has a specified subset.
     *
     * This method was taken over from PHPUnit where it was deprecated. See link for more info.
     *
     * @param  array|\ArrayAccess  $subset
     * @param  array|\ArrayAccess  $array
     * @param  bool  $checkForObjectIdentity
     * @param  string  $message
     * @return void
     *
     * @link https://github.com/sebastianbergmann/phpunit/issues/3494
     */
    public static function assertArraySubset($subset, $array, bool $checkForObjectIdentity = false, string $message = ''): void
    {
        if (! (is_array($subset) || $subset instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(1, 'array or ArrayAccess');
        }
        if (! (is_array($array) || $array instanceof ArrayAccess)) {
            throw InvalidArgumentHelper::factory(2, 'array or ArrayAccess');
        }
        $constraint = new ArraySubset($subset, $checkForObjectIdentity);
        static::assertThat($array, $constraint, $message);
    }
}
