<?php

namespace Jackal\Downloader;

use Jackal\Downloader\Downloader\DownloaderInterface;
use Jackal\Downloader\Exception\DownloadException;

class VideoDownloader
{
    protected $downloaders = [];

    public function registerDownloader($name, $downloaderClass) : void
    {
        if (is_object($downloaderClass)) {
            $downloaderClass = get_class($downloaderClass);
        }

        if (array_key_exists($name, $this->downloaders)) {
            throw DownloadException::alreadyRegistered($name);
        }
        $this->downloaders[$name] = $downloaderClass;
    }

    public function getRegisteredDownloaders() : array
    {
        return $this->downloaders;
    }

    /**
     * @param $nameOrNamespace
     * @param $id
     * @param array $config
     * @return DownloaderInterface
     * @throws \Exception
     */
    public function getDownloader($nameOrNamespace, $id, $config = []) : DownloaderInterface
    {
        if (!array_key_exists($nameOrNamespace, $this->downloaders)) {
            throw new \Exception('Invalid video_type or namespace [' . $nameOrNamespace . ']');
        }

        return new $this->downloaders[$nameOrNamespace]($id, $config);
    }
}
