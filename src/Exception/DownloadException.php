<?php

namespace Jackal\Downloader\Exception;

class DownloadException extends \Exception
{
    /**
     * @param string $name
     * @return DownloadException
     */
    public static function invalidName(string $name){
        return new DownloadException(sprintf('Downloader type "%s" not found', $name));
    }

    /**
     * @param string $publicUrl
     * @return DownloadException
     */
    public static function invalidPublicUrl(string $publicUrl){
        return new DownloadException('Downloader not found [trying to parse: ' . $publicUrl . ']');
    }

    /**
     * @param string $tempFile
     * @return DownloadException
     */
    public static function tempFileAlreadyExists(string $tempFile) : DownloadException
    {
        return new DownloadException(sprintf('Temp file "%s" already exists, use force to overwrite', $tempFile));
    }

    /**
     * @param string $name
     * @return DownloadException
     */
    public static function alreadyRegistered(string $name) : DownloadException
    {
        return new DownloadException(sprintf('Downloader with name "%s" is already registered', $name));
    }

    /**
     * @param string $destinationFile
     * @return DownloadException
     */
    public static function destinationFileAlreadyExists(string $destinationFile) : DownloadException
    {
        return new DownloadException(sprintf('Output file "%s" already exists. Use option `overwrite` to force', $destinationFile));
    }

    /**
     * @param string $folder
     * @return DownloadException
     */
    public static function cannotCreateDirectory(string $folder) : DownloadException
    {
        return new DownloadException('Unable to create directory ' . $folder);
    }

    /**
     * @param string $message
     * @return DownloadException
     */
    public static function downloadError(string $message) : DownloadException
    {
        return new DownloadException($message);
    }

    /**
     * @param array $selectedFormats
     * @param array $available
     * @return DownloadException
     */
    public static function formatNotFound(array $selectedFormats, array $available) : DownloadException
    {
        return new DownloadException(sprintf(
            'Format%s %s is not available. [Available formats are: %s]',
            count($selectedFormats) == 1 ? '' : 's',
            implode(', ', $selectedFormats),
            implode(', ', array_keys($available))
        ));
    }
}
