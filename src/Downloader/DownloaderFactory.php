<?php


namespace Jackal\Downloader;


class DownloaderFactory
{
    const TYPE_YOUTUBE = 'youtube';

    private static $downloaders = [
        self::TYPE_YOUTUBE => YoutubeDownloader::class
    ];

    /**
     * @param $videoTypeOrNamespace
     * @param $id
     * @return YoutubeDownloader
     * @throws \Exception
     */
    public static function getInstance($videoTypeOrNamespace,$id)
    {
        if(class_exists($videoTypeOrNamespace)){
            return new $videoTypeOrNamespace($id);
        }

        if(!array_key_exists($videoTypeOrNamespace,self::$downloaders)){
            throw new \Exception('Invalid video_type or namespace ['.$videoTypeOrNamespace.']');
        }

        return new self::$downloaders[$videoTypeOrNamespace]($id);
    }
}