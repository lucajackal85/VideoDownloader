<?php

namespace Jackal\Downloader\Exception;

class DownloadException extends \Exception
{
    public static function tempFileAlreadyExists($tempFile) : DownloadException
    {
        return new DownloadException(sprintf('Temp file "%s" already exists, use force to overwrite', $tempFile));
    }

    public static function alreadyRegistered($name) : DownloadException
    {
        return new DownloadException(sprintf('Downloader with name "%s" is already registered', $name));
    }

    public static function destinationFileAlreadyExists($destinationFile) : DownloadException
    {
        return new DownloadException(sprintf('Output file "%s" already exists. Use option `overwrite` to force', $destinationFile));
    }

    public static function cannotCreateDirectory($folder) : DownloadException
    {
        return new DownloadException('Unable to create directory ' . $folder);
    }
}
