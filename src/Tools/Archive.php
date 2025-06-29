<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

class Archive
{
    private function __construct()
    {
    }

    /**
     * Creates a simple zip archive from a list of files (absolute paths) in the given directory.
     *
     * The files are deleted after the archive is created.
     *
     * @param string $archiveDirectory
     * @param string $archiveName
     * @param string $filesDirectory
     * @param array<string> $filenames
     *
     * @return ?string the full path of the created archive or null if an error occurred
     */
    public static function createArchive(
        string $archiveDirectory,
        string $archiveName,
        string $filesDirectory,
        array $filenames
    ): ?string {
        $archiveFullPath = null;
        $recoveredFiles = File::recoverFilesFromDirectory($filesDirectory, $filenames);

        if ($recoveredFiles === []) {
            return $archiveFullPath;
        }

        $archiveFullPath = "$archiveDirectory . $archiveName";
        $zip = new \ZipArchive();

        if (\is_file($archiveFullPath)) {
            $archive = $zip->open($archiveFullPath, \ZipArchive::OVERWRITE);
        } else {
            $archive = $zip->open($archiveFullPath, \ZipArchive::CREATE);
        }

        if ($archive === true) {
            foreach ($recoveredFiles as $filename) {
                $zip->addFile("$filesDirectory$filename", $filename);
            }
            $closedSuccesfully = $zip->close();
            if ($closedSuccesfully) {
                foreach ($recoveredFiles as $file) {
                    File::deleteFile($filesDirectory . $file);
                }
            }
        }

        return $archiveFullPath;
    }
}
