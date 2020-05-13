<?php

namespace Jackal\Downloader\Downloader;

interface DownloaderInterface
{
    public function __construct($id, array $config = []);

    public static function getPublicUrlRegex() : string;
    public static function getType() : string;

    public function getFormatsAvailable() : array;
    public function setFormat($format) : self;
    public function getVideoId() : string;

    public function getURL() : string;
    public function download(string $destinationFile, callable $callback = null) : void;
    public function getOptions() : array;
}
