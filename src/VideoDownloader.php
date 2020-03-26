<?php

namespace Jackal\Downloader;

use Jackal\Downloader\Downloader\DownloaderInterface;
use Jackal\Downloader\Downloader\YoutubeDownloader;
use Jackal\Downloader\Exception\DownloadException;

class VideoDownloader
{
    const TYPE_YOUTUBE = 'youtube';

    protected $downloaders = [
        self::TYPE_YOUTUBE => YoutubeDownloader::class,
    ];

    public function registerDownloader($name, $downloaderClass){
        if(is_object($downloaderClass)) {
            $downloaderClass = get_class($downloaderClass);
        }

        if(array_key_exists($name, $this->downloaders)){
            throw DownloadException::alreadyRegistered($name);
        }
        $this->downloaders[$name] = $downloaderClass;
    }

    public function getRegisteredDownloaders(){
        return $this->downloaders;
    }

    /**
     * @param $nameOrNamespace
     * @param $id
     * @param array $config
     * @return DownloaderInterface
     * @throws \Exception
     */
    public function getDownloader($nameOrNamespace, $id, $config = []){

        if(!array_key_exists($nameOrNamespace, $this->downloaders)){
            throw new \Exception('Invalid video_type or namespace [' . $nameOrNamespace . ']');
        }

        return new $this->downloaders[$nameOrNamespace]($id, $config);
    }
}