<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Enums\Http;

use Corbocal\Utilities\Enums\Traits\EnumUtilsTrait;

enum PsrLogLevelsEnum: string
{
    use EnumUtilsTrait;

    case EMERGENCY = "emergency";
    case ALERT = "alert";
    case CRITICAL = "critical";
    case ERROR = "error";
    case WARNING = "warning";
    case NOTICE = "notice";
    case INFO = "info";
    case DEBUG = "debug";
}
