<?php

namespace Jackal\Downloader;

use Jackal\Downloader\Downloader\DownloaderInterface;
use Jackal\Downloader\Exception\DownloadException;
use Jackal\Downloader\Parser\URLRegexParser;

class VideoDownloader
{
    /**
     * @var string[]
     */
    protected $downloaders = [];

    /**
     * @param string $downloaderClass
     * @throws DownloadException
     */
    public function registerDownloader($downloaderClass) : void
    {
        if (is_object($downloaderClass)) {
            $downloaderClass = get_class($downloaderClass);
        }
        /** @var DownloaderInterface $downloaderClass */
        if (array_key_exists($downloaderClass::getType(), $this->downloaders)) {
            throw DownloadException::alreadyRegistered($downloaderClass::getType());
        }
        $this->downloaders[$downloaderClass::getType()] = $downloaderClass;
    }

    /**
     * @return string[]
     */
    public function getRegisteredDownloaders() : array
    {
        return $this->downloaders;
    }

    /**
     * @param string $name
     * @param $id
     * @param array $config
     * @return DownloaderInterface
     * @throws DownloadException
     */
    public function getDownloader(string $name, $id, array $config = []) : DownloaderInterface
    {
        if (!array_key_exists($name, $this->downloaders)) {
            throw DownloadException::invalidName($name);
        }

        return new $this->downloaders[$name]($id, $config);
    }

    /**
     * @param $publicUrl
     * @param array $config
     * @return DownloaderInterface
     * @throws DownloadException
     */
    public function getDownloaderByPublicUrl($publicUrl,$config = []) : DownloaderInterface{
        foreach ($this->getRegisteredDownloaders() as $downloaderClass){
            $regexParser = new URLRegexParser($downloaderClass);
            if($regexParser->isValidUrl($publicUrl)){
                return new $downloaderClass($regexParser->parse($publicUrl),$config);
            }
        }

        throw DownloadException::invalidPublicUrl($publicUrl);
    }
}
