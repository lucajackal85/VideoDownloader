<?php

namespace Jackal\Downloader\Downloader;

interface DownloaderInterface
{
    public function __construct($id, $config = []);

    public function getURL() : string;
    public function download($destinationFile, callable $callback = null) : void;
    public function getOptions() : array;
}
