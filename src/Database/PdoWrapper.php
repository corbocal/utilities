<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Database;

class PdoWrapper
{
    protected \PDO $pdo;

    public function __construct(
        #[\SensitiveParameter]
        string $dbUrl,
        ?string $driverOverride = null,
        ?string $charsetOverride = null
    ) {
        $parsedUrl = parse_url($dbUrl);
        if ($parsedUrl === false) {
            throw new \InvalidArgumentException(
                "Invalid database URL format.",
                500
            );
        }
        $host = $parsedUrl['host'] ?? "";
        $port = $parsedUrl['port'] ?? 3306;
        $dbname = ltrim($parsedUrl['path'] ?? "", '/');
        $username = $parsedUrl['user'] ?? "";
        $password = $parsedUrl['pass'] ?? "";
        $driver = $driverOverride ?? 'mysql';
        $charset = $charsetOverride ?? 'utf8mb4';
        $this->pdo = new \PDO(
            "$driver:host=$host:$port;dbname=$dbname;charset=$charset",
            $username,
            $password
        );
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
