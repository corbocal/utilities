<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Enums\Http;

use Corbocal\Utilities\Enums\Http\StatusMessagesEnum;
use Corbocal\Utilities\Enums\Traits\EnumUtilsTrait;

enum StatusCodesEnum: int
{
    use EnumUtilsTrait;

    case CONTINUE = 100;
    case SWITCHING_PROTOCOLS = 101;
    case PROCESSING = 102;
    case EARLY_HINTS = 103;

    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NON_AUTHORITATIVE_INFORMATION = 203;
    case NO_CONTENT = 204;
    case RESET_CONTENT = 205;
    case PARTIAL_CONTENT = 206;
    case MULTI_STATUS = 207;
    case ALREADY_REPORTED = 208;
    case IM_USED = 226;

    case MULTIPLE_CHOICES = 300;
    case MOVED_PERMANENTLY = 301;
    case FOUND = 302;
    case SEE_OTHER = 303;
    case NOT_MODIFIED = 304;
    case TEMPORARY_REDIRECT = 307;
    case PERMANENT_REDIRECT = 308;

    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case PAYMENT_REQUIRED = 402;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case NOT_ACCEPTABLE = 406;
    case PROXY_AUTHENTICATION_REQUIRED = 407;
    case REQUEST_TIMEOUT = 408;
    case CONFLICT = 409;
    case GONE = 410;
    case LENGTH_REQUIRED = 411;
    case PRECONDITION_FAILED = 412;
    case PAYLOAD_TOO_LARGE = 413;
    case URI_TOO_LONG = 414;
    case UNSUPPORTED_MEDIA_TYPE = 415;
    case RANGE_NOT_SATISFIABLE = 416;
    case EXPECTATION_FAILED = 417;
    case IM_A_TEAPOT = 418;
    case MISDIRECTED_REQUEST = 421;
    case UNPROCESSABLE_CONTENT = 422;
    case LOCKED = 423;
    case FAILED_DEPENDENCY = 424;
    case TOO_EARLY = 425;
    case UPGRADE_REQUIRED = 426;
    case PRECONDITION_REQUIRED = 428;
    case TOO_MANY_REQUESTS = 429;
    case REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    case UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    case INTERNAL_SERVER_ERROR = 500;
    case NOT_IMPLEMENTED = 501;
    case BAD_GATEWAY = 502;
    case SERVICE_UNAVAILABLE = 503;
    case GATEWAY_TIMEOUT = 504;
    case HTTP_VERSION_NOT_SUPPORTED = 505;
    case VARIANT_ALSO_NEGOTIATES = 506;
    case INSUFFICIENT_STORAGE = 507;
    case LOOP_DETECTED = 508;
    case NOT_EXTENDED = 510;
    case NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * Checks if passed int is an actual HTTP status code.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isActualHttpCode(int $code): bool
    {

        return in_array($code, self::allValues());
    }

    /**
     * Code between 100 and 199 are informational.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isInformational(int $code): bool
    {
        return $code >= 100 && $code < 200;
    }

    /**
     * Code between 200 and 299 are successful.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isSuccess(int $code): bool
    {
        return $code >= 200 && $code < 300;
    }

    /**
     * Code between 300 and 399 are redirection.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isRedirection(int $code): bool
    {
        return $code >= 300 && $code < 400;
    }

    /**
     * Code between 400 and 499 are client error.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isClientError(int $code): bool
    {
        return $code >= 400 && $code < 500;
    }

    /**
     * Code between 500 and 599 are server error.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isServerError(int $code): bool
    {
        return $code >= 500 && $code < 600;
    }

    /**
     * Wrapper for `isServerError` and `isClientError`.
     *
     * @param int $code
     *
     * @return bool
     */
    public static function isError(int $code): bool
    {
        return self::isClientError($code) || self::isServerError($code);
    }
}
