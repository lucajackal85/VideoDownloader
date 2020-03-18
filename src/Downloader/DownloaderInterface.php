<?php


namespace Jackal\Downloader\Downloader;


interface DownloaderInterface
{
    public function getURL();
    public function download($destinationFile);

}