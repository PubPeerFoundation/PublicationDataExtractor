<?php

namespace XavRsl\PublicationDataExtractor\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public function dateFromDateParts(array $parts)
    {
        if (empty($parts)) {
            return '';
        }

        return $this->formatForParts(
            Carbon::createFromDate(...array_merge($parts, [1, 1, 1])),
            count($parts)
        );
    }

    public function dateFromCommonFormat($formattedDate)
    {
        return Carbon::parse($formattedDate)->format('Y-m-d');
    }

    public function dateFromPubDate($pubDateObject)
    {
        if (!isset($pubDateObject->Year) || empty($pubDateObject->Year)) {
            return '';
        }

        $month = $this->getPubDateMonth($pubDateObject);

        return $this->formatForParts(Carbon::create(
            (int) $pubDateObject->Year,
            (int) $month,
            isset($pubDateObject->Day) ? (int) $pubDateObject->Day : 1
        ), $this->countObjectParts($pubDateObject));
    }

    protected function getPubDateMonth($pubDateObject)
    {
        if (!isset($pubDateObject->Month)) {
            return 1;
        }

        return !is_numeric((string) $pubDateObject->Month)
            ? Carbon::createFromFormat('M', (string) $pubDateObject->Month)->format('n')
            : $pubDateObject->Month;
    }

    protected function formatForParts($date, $count)
    {
        $partsToFormat = [
            1 => 'Y',
            2 => 'Y-m',
            3 => 'Y-m-d',
        ];

        return $date->format($partsToFormat[$count]);
    }

    protected function countObjectParts($pubDateObject)
    {
        return array_reduce(['Year', 'Month', 'Day'], function ($carry, $datePart) use ($pubDateObject) {
            return isset($pubDateObject->$datePart) ? $carry + 1 : $carry;
        }, 0);
    }
}
