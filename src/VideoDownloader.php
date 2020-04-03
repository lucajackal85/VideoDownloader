<?php

namespace Jackal\Downloader;

use Jackal\Downloader\Downloader\DownloaderInterface;
use Jackal\Downloader\Exception\DownloadException;

class VideoDownloader
{
    /**
     * @var string[]
     */
    protected $downloaders = [];

    /**
     * @param string $name
     * @param string|object $downloaderClass
     * @throws DownloadException
     */
    public function registerDownloader(string $name, $downloaderClass) : void
    {
        if (is_object($downloaderClass)) {
            $downloaderClass = get_class($downloaderClass);
        }

        if (array_key_exists($name, $this->downloaders)) {
            throw DownloadException::alreadyRegistered($name);
        }
        $this->downloaders[$name] = $downloaderClass;
    }

    /**
     * @return string[]
     */
    public function getRegisteredDownloaders() : array
    {
        return $this->downloaders;
    }

    /**
     * @param string $nameOrNamespace
     * @param string $id
     * @param string[] $config
     * @return DownloaderInterface
     * @throws DownloadException
     */
    public function getDownloader(string $nameOrNamespace, $id, array $config = []) : DownloaderInterface
    {
        if (!array_key_exists($nameOrNamespace, $this->downloaders)) {
            throw new DownloadException('Invalid video_type or namespace [' . $nameOrNamespace . ']');
        }

        return new $this->downloaders[$nameOrNamespace]($id, $config);
    }
}
