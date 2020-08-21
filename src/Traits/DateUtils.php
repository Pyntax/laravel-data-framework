<?php

namespace Pyntax\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Trait DateUtils
 *
 * @package TradeGuard\Crm\Resources\Traits
 */
trait DateUtils
{
    /**
     * @param $value
     * @param  string  $fromFormat
     * @param  string  $format
     *
     * @return string|null
     */
    public function parseDateForDB($value, string $fromFormat = 'd/m/Y', string $format = 'Y-m-d')
    {
        try {
            return \DateTime::createFromFormat($fromFormat, $value)->format($format);
        } catch (\Exception $exception) {
            Log::error("Failed to parse date $value. Error: ".$exception->getMessage());
        }

        return null;
    }

    /**
     * @param  string  $field
     * @param  string  $format
     * @param  string  $timeZone
     *
     * @return string|null
     */
    public function renderDate(string $field, string $format = 'd/m/Y H:i:s a', string $timeZone = 'Australia/Sydney')
    {
        if (!empty($this->{$field})) {
            try {
                return Carbon::parse($this->{$field})->setTimezone(
                    new \DateTimeZone($timeZone)
                )->format($format);
            } catch (\Exception $exception) {
                return $this->{$field};
            }
        }

        return null;
    }
}