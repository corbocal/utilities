<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

class File
{
    private function __construct()
    {
    }

    /**
     * Deletes a file.
     *
     * @param string $path the full path to the file.
     *
     * @return bool __true__ if the file could be deleted, __false__ otherwise
     */
    public static function deleteFile($path): bool
    {
        return \is_file($path) ? \unlink($path) : false;
    }

    /**
     * Deletes a directory __recursively__.
     *
     * @param string $path the full path to the directory.
     *
     * @return bool __true__ if the directory could be deleted, __false__ otherwise
     */
    public static function deleteDirectory($path): bool
    {
        if (!\is_dir($path)) {
            return false;
        }
        $files = \array_diff(\scandir($path), ['.', '..']);
        foreach ($files as $file) {
            (\is_dir("$path/$file")) ? self::deleteDirectory("$path/$file") : \unlink("$path/$file");
        }

        return \rmdir($path);
    }

    /**
     * Creates a directory
     *
     * @param string $path the full path to the desired directory.
     *
     * @return bool __true__ if the directory could be created, __false__ otherwise
     */
    public static function createDirectory(string $path, int $permission = 0755): bool
    {
        return !\is_dir($path) ? \mkdir($path, $permission, true) : false;
    }

    /**
     * Scans a given directory and returns an array of files.
     *
     * @param string $pathToDirectory the full path to the desired directory.
     * @param array<string> $filenames specific filenames to recover. If empty, all files are recovered.
     *
     * @return array<string> the array of files in the directory.
     */
    public static function recoverFilesFromDirectory(string $pathToDirectory, array $filenames = []): array
    {
        $files = [];

        $scannedDir = \scandir($pathToDirectory);

        if (\is_array($scannedDir)) {
            $scannedDir = \array_values(\array_diff($scannedDir, ['..', '.']));

            if ($filenames === []) {
                $files = $scannedDir;
            } else {
                foreach ($scannedDir as $file) {
                    if (\preg_grep("/$file/", $filenames)) {
                        $files[] = $file;
                    }
                }
            }
        }

        return $files;
    }

    /**
     * Sends a file to the client.
     *
     * @param string $path the full path to the desired directory.
     *
     * @throws \InvalidArgumentException if the file does not exist.
     *
     * @return never
     */
    public static function download(string $path): never
    {
        if (!\is_file($path)) {
            throw new \InvalidArgumentException(
                "The file $path does not exist.",
                500
            );
        }

        \header('Content-type: "application/zip";');
        \header('Content-disposition: attachment; filename="' . basename($path) . '"');
        exit();
    }
}
