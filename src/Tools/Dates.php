<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

class Dates
{
    public const int SECONDS_IN_MINUTE = 60;
    public const int SECONDS_IN_HOUR = 3600;
    public const int SECONDS_IN_DAY = 86400;
    public const int SECONDS_IN_WEEK = 604800;
    public const int SECONDS_IN_YEAR = 31536000;
    public const int MINUTES_IN_HOUR = 60;
    public const int MINUTES_IN_DAY = 1440;
    public const int MINUTES_IN_WEEK = 10080;
    public const int MINUTES_IN_YEAR = 525600;
    public const int HOURS_IN_DAY = 24;
    public const int HOURS_IN_WEEK = 168;
    public const int HOURS_IN_YEAR = 8760;
    public const int DAYS_IN_WEEK = 7;

    public const string FORMAT_STD = "Y-m-d H:i:s";
    public const string FORMAT_STD_TMZ = "Y-m-d H:i:s U";

    private function __construct()
    {
    }

    private static function dateTimeInterfaceInstance(string $datetime = "", bool $immutable = true): \DateTimeImmutable|\DateTime
    {
        return $immutable ? new \DateTimeImmutable($datetime) : new \DateTime($datetime);
    }

    /**
     * Returns a \DateTimeInterface instance, or null, depending on what's needed.
     *
     * @param \DateTimeInterface|string|null $date the date
     * * if __null__ and `$nullable` __true__, returns __null__.
     * * if __null__ and `$nullable` __false__, returns the \DateTimeInterface of now.
     * * if a __string__, returns the `\DateTimeInterface` associated to the time representation of `$date`.
     * * if already a `\DateTimeInterface` instance, returns it.
     * @param bool $nullable can the date be null?
     * @param bool $immutable should the result instance be immutable?
     * @param ?\DateTimeZone $timezone if null, will set UTC by default.
     *
     * @return ?\DateTimeInterface
     */
    public static function generate(
        \DateTimeInterface|string|null $date = null,
        bool $nullable = false,
        bool $immutable = true,
        ?\DateTimeZone $timezone = null,
    ): ?\DateTimeInterface {
        $result = null;

        if ($date instanceof \DateTimeInterface) {
            $result = self::dateTimeInterfaceInstance($date->format(\DateTimeInterface::ISO8601_EXPANDED), $immutable);
        } elseif (is_string($date) || !$nullable) {
            $result = self::dateTimeInterfaceInstance($date ?? "now", $immutable);
        }

        $result = $result?->setTimezone($timezone ?? new \DateTimeZone("UTC"));

        return $result;
    }

    /**
     * Returns how many days there are between two timestamps (2 decimals)
     *
     * @param int $timestamp1
     * @param int $timestamp2
     *
     * @return float The number of days between the two timestamps, as an absolute value.
     */
    public static function getDaysBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_DAY), 2);
    }

    /**
     * Returns how many hours there are between two timestamps (2 decimals)
     *
     * @param int $timestamp1
     * @param int $timestamp2
     *
     * @return float The number of hours between the two timestamps, as an absolute value.
     */
    public static function getHoursBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_HOUR), 2);
    }

    /**
     * Returns how many minutes there are between two timestamps (2 decimal)
     *
     * @param int $timestamp1
     * @param int $timestamp2
     *
     * @return float The number of minutes between the two timestamps, as an absolute value.
     */
    public static function getMinutesBetweenTimestamps(int $timestamp1, int $timestamp2): float
    {
        return \round((\abs($timestamp1 - $timestamp2) / self::SECONDS_IN_MINUTE), 2);
    }

    private static function toTimestamp(\DateTimeInterface|int|string $time): int
    {
        if ($time instanceof \DateTimeInterface) {
            $time = $time->getTimestamp(); // timezone agnostic
        }

        if (is_string($time)) {
            $time = strtotime($time) ?: time();
        }

        return $time;
    }

    /**
     * Returns how many seconds there are between two times.
     *
     * They can be either a timestamp, a \DateTimeInterface or a string representation as a date.\
     * Does not work for/with microseconds.
     *
     * @param \DateTimeInterface|string|int $date1
     * @param \DateTimeInterface|string|int $date2
     *
     * @return int
     */
    public static function getSecondsBetween(
        \DateTimeInterface|string|int $date1,
        \DateTimeInterface|string|int $date2
    ): int {
        $date1 = self::toTimestamp($date1);
        $date2 = self::toTimestamp($date2);

        return \abs($date1 - $date2);
    }
}
