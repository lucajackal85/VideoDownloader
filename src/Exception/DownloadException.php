<?php

namespace Jackal\Downloader\Exception;

class DownloadException extends \Exception
{
    public static function tempFileAlreadyExists($tempFile){
        return new DownloadException(sprintf('Temp file "%s" already exists, use force to overwrite', $tempFile));
    }

    public static function alreadyRegistered($name){
        return new DownloadException(sprintf('Downloader with name "%s" is already registered', $name));
    }
}