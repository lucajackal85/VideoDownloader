<?php

namespace Jackal\Downloader\Downloader;

interface DownloaderInterface
{
    public function __construct($id, $config = []);

    public function getURL() : string;
    public function download($destinationFile) : void;
    public function getOptions() : array;

}