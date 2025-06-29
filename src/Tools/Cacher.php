<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Cacher;

use Corbocal\Utilities\Tools\File;

class Cacher
{
    protected const string DEFAULT_CACHE_DIR_PATH = "/var/cache";
    protected const string DEFAULT_CONFIG_FILE_PATH = "/config/cacher.yaml";

    protected readonly string $appRootDir;
    protected readonly bool $isCacheOn;
    protected readonly string $cacheDir;

    /**
     * @var string[]
     */
    protected readonly array $registryFiles;

    /**
     * @param string $appRootDir
     * @param bool $isCacheOn
     * @param array<string,string> $registryFiles
     * @param string $cacheDir
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $appRootDir,
        bool $isCacheOn,
        array $registryFiles,
        string $cacheDir = self::DEFAULT_CACHE_DIR_PATH,
    ) {
        $realpath = \realpath($appRootDir);
        if ($realpath === false) {
            throw new \InvalidArgumentException(
                "The path $appRootDir does not exist.",
                500
            );
        }
        $this->appRootDir = $realpath;
        if (\substr($cacheDir, 0, 1) === '/') {
            $dir = "$realpath$cacheDir";
        } else {
            $dir = "$realpath/$cacheDir";
        }
        $this->cacheDir = $dir;
        $this->registryFiles = $registryFiles;
        $this->isCacheOn = $isCacheOn;
    }

    /**
     * @return string the directory __without__ the trailing slash
     */
    public function getAppRootDir(): string
    {
        return $this->appRootDir;
    }

    /**
     * @return string the directory __without__ the trailing slash
     */
    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    public function isCacheOn(): bool
    {
        return $this->isCacheOn;
    }

    protected function createBaseCacheDirectory(): void
    {
        if (!\is_dir($this->getCacheDir())) {
            echo 'Cacher.php' . ' L:114' . PHP_EOL;
            $directory = File::createDirectory($this->getCacheDir(), 0777);

            if ($directory === false) {
                throw new \RuntimeException(
                    "Unable to create directory {$this->getCacheDir()}",
                    500
                );
            }
        }
    }

    /**
     * Converts the variable content to a string via output buffer.
     * @param mixed $data The variable to convert
     * @return string The string representation of the variable
     */
    protected static function variableContentToText(mixed $data, ?string $variableName = null): string
    {
        \ob_start();
        echo \var_export($data, true);
        $output = \ob_get_contents();
        \ob_end_clean();

        if (!empty($variableName)) {
            $output = "\$$variableName = $output;";
        }

        return strval($output);
    }

    private static function writeCacheDataInFile(string $fullPathToCacheFile, string $content): bool
    {
        $result = false;
        if (!\is_file($fullPathToCacheFile)) {
            $content = "<?php" . PHP_EOL . $content;
            $result = \file_put_contents($fullPathToCacheFile, $content);
        } else {
            $varnameToExtract = str_replace(
                "$",
                "",
                trim(substr($content, 0, intval(strpos($content, "="))))
            );
            include $fullPathToCacheFile;
            if (isset($$varnameToExtract)) {
                // dump('content existe');
                // TODO
            } else {
                $result = \file_put_contents($fullPathToCacheFile, $content, FILE_APPEND);
                // dump('creation du content');
                // TODO
            }
        }

        return $result !== false;
    }

    public function cacheContent(string $variableName, mixed $data, string $relativePathToCacheFile): bool
    {
        $this->createBaseCacheDirectory();
        $fullPath = $this->getCacheDir() . $relativePathToCacheFile;
        $dataToWrite = self::variableContentToText($data, $variableName);
        $result = self::writeCacheDataInFile($fullPath, $dataToWrite);

        return $result;
    }


    public function getCachedContent(): void
    {
        // TODO
    }
}
