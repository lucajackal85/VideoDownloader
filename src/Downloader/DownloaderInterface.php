<?php

namespace Jackal\Downloader\Downloader;

interface DownloaderInterface
{
    public function __construct($id, array $config = []);

    public function getURL() : string;
    public function download(string $destinationFile, callable $callback = null) : void;
    public function getOptions() : array;
}
