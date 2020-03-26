<?php

namespace Jackal\Downloader\Downloader;

use Jackal\Downloader\Exception\DownloadException;
use Jackal\Downloader\Utils\DownloaderUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YoutubeDownloader implements DownloaderInterface {
    /** @var array $options */
    protected $options;
    /** @var string $youtubeVideoURL */
    protected $youtubeVideoURL;

    protected $tempFilePathName;

    public function __construct($id, $config = [])
    {
        $options = new OptionsResolver();
        $options->setDefaults([
            'force' => true,
            'youtube_id' => $id,
            'format' => null,
        ]);

        $options->setRequired('youtube_id');
        $this->options = $options->resolve($config);
    }

    public function getURL() : string {

        if(!filter_var($this->getYoutubeId(), FILTER_VALIDATE_URL)){
            $this->youtubeVideoURL = 'https://www.youtube.com/watch?v=' . $this->getYoutubeId();
        }

        $yt = new \YouTube\YouTubeDownloader();
        $links = $yt->getDownloadLinks($this->youtubeVideoURL);

        $videos = array_values($links);

        $formatVideos = [];

        foreach ($videos as $video){
            if(isset($video['format'])) {
                preg_match('/([0-9]{2,4})p/', $video['format'], $match);
                if(isset($match[1])){
                    $formatVideos[$match[1]] = $video['url'];
                }
            }
        }

        ksort($formatVideos, SORT_NUMERIC);

        if($this->getFormat() and !isset($formatVideos[$this->getFormat()])){
            throw new \Exception(
                sprintf('Format %s is not available. Possible formats are %s',
                    $this->getFormat(), implode(', ', array_keys($formatVideos))
                )
            );
        }

        return $this->getFormat() ? $formatVideos[$this->getFormat()] : end($formatVideos);
    }

    public function download($destinationFile) : void {
        if(!is_dir(dirname($destinationFile))){
            if(!mkdir(dirname($destinationFile), 0777, true)){
                throw new \Exception('Unable to create directory ' . dirname($destinationFile));
            }
        }

        $this->tempFilePathName = $destinationFile . '.temp';

        if(file_exists($this->tempFilePathName) and !$this->getForce()){
            throw DownloadException::tempFileAlreadyExists($this->tempFilePathName);
        }

        DownloaderUtil::downloadURL($this->getURL(), $this->tempFilePathName);
        rename($this->tempFilePathName, $destinationFile);

    }

    public function __destruct()
    {
        if(is_file($this->tempFilePathName)){
            unlink($this->tempFilePathName);
        }
    }

    protected function getYoutubeId() : string {
        return $this->options['youtube_id'];
    }

    protected function getForce(){
        return $this->options['force'];
    }

    protected function getFormat() : string {
        return $this->options['format'];
    }
}