<?php


namespace Jackal\Downloader;


interface DownloaderInterface
{
    public function getURL();
    public function download($destinationFile);

}