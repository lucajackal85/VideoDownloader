<?php

namespace Jackal\Downloader\Downloader;

interface DownloaderInterface
{
    public function __construct($id, $config = []);

    public function download($destinationFile);

}