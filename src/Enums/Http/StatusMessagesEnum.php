<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Enums\Http;

use Corbocal\Utilities\Enums\Traits\EnumUtilsTrait;
use Corbocal\Utilities\Enums\Http\StatusCodesEnum;

enum StatusMessagesEnum: string
{
    use EnumUtilsTrait;

    case CONTINUE = "Continue";
    case SWITCHING_PROTOCOLS = "Switching Protocols";
    case PROCESSING = "Processing";
    case EARLY_HINTS = "Early Hints";

    case OK = "OK";
    case CREATED = "Created";
    case ACCEPTED = "Accepted";
    case NON_AUTHORITATIVE_INFORMATION = "Non-Authoritative Information";
    case NO_CONTENT = "No Content";
    case RESET_CONTENT = "Reset Content";
    case PARTIAL_CONTENT = "Partial Content";
    case MULTI_STATUS = "Multi-Status";
    case ALREADY_REPORTED = "Already Reported";
    case IM_USED = "IM Used";

    case MULTIPLE_CHOICES = "Multiple Choices";
    case MOVED_PERMANENTLY = "Moved Permanently";
    case FOUND = "Found";
    case SEE_OTHER = "See Other";
    case NOT_MODIFIED = "Not Modified";
    case TEMPORARY_REDIRECT = "Temporary Redirect";
    case PERMANENT_REDIRECT = "Permanent Redirect";

    case BAD_REQUEST = "Bad Request";
    case UNAUTHORIZED = "Unauthorized";
    case PAYMENT_REQUIRED = "Payment Required";
    case FORBIDDEN = "Forbidden";
    case NOT_FOUND = "Not Found";
    case METHOD_NOT_ALLOWED = "Method Not Allowed";
    case NOT_ACCEPTABLE = "Not Acceptable";
    case PROXY_AUTHENTICATION_REQUIRED = "Proxy Authentication Required";
    case REQUEST_TIMEOUT = "Request Timeout";
    case CONFLICT = "Conflict";
    case GONE = "Gone";
    case LENGTH_REQUIRED = "Length Required";
    case PRECONDITION_FAILED = "Precondition Failed";
    case PAYLOAD_TOO_LARGE = "Payload Too Large";
    case URI_TOO_LONG = "URI Too Long";
    case UNSUPPORTED_MEDIA_TYPE = "Unsupported Media Type";
    case RANGE_NOT_SATISFIABLE = "Range Not Satisfiable";
    case EXPECTATION_FAILED = "Expectation Failed";
    case IM_A_TEAPOT = "I'm a Teapot";
    case MISDIRECTED_REQUEST = "Misdirected Request";
    case UNPROCESSABLE_CONTENT = "Unprocessable Content";
    case LOCKED = "Locked";
    case FAILED_DEPENDENCY = "Failed Dependency";
    case TOO_EARLY = "Too Early";
    case UPGRADE_REQUIRED = "Upgrade Required";
    case PRECONDITION_REQUIRED = "Precondition Required";
    case TOO_MANY_REQUESTS = "Too Many Requests";
    case REQUEST_HEADER_FIELDS_TOO_LARGE = "Request Header Fields Too Large";
    case UNAVAILABLE_FOR_LEGAL_REASONS = "Unavailable For Legal Reasons";

    case INTERNAL_SERVER_ERROR = "Internal Server Error";
    case NOT_IMPLEMENTED = "Not Implemented";
    case BAD_GATEWAY = "Bad Gateway";
    case SERVICE_UNAVAILABLE = "Service Unavailable";
    case GATEWAY_TIMEOUT = "Gateway Timeout";
    case VERSION_NOT_SUPPORTED = "HTTP Version Not Supported";
    case VARIANT_ALSO_NEGOTIATES = "Variant Also Negotiates";
    case INSUFFICIENT_STORAGE = "Insufficient Storage";
    case LOOP_DETECTED = "Loop Detected";
    case NOT_EXTENDED = "Not Extended";
    case NETWORK_AUTHENTICATION_REQUIRED = "Network Authentication Required";
}
