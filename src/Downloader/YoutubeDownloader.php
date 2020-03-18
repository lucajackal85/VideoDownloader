<?php


namespace Jackal\Downloader;


class YoutubeDownloader implements DownloaderInterface {

    protected $youtubeVideo = null;
    protected $format = null;

    public function __construct($youtubeVideo,$format = null)
    {
        $this->format = $format;
        $this->youtubeVideo = $youtubeVideo;
    }

    public function getURL(){

        if(!filter_var($this->youtubeVideo,FILTER_VALIDATE_URL)){
            $this->youtubeVideo = 'https://www.youtube.com/watch?v='.$this->youtubeVideo;
        }

        $yt = new \YouTube\YouTubeDownloader();
        $links = $yt->getDownloadLinks($this->youtubeVideo);

        $videos = array_values($links);

        $formatVideos = [];

        foreach ($videos as $video){
            if(isset($video['format'])) {
                preg_match('/([0-9]{2,4})p/', $video['format'],$match);
                if(isset($match[1])){
                    $formatVideos[$match[1]] = $video['url'];
                }
            }
        }

        ksort($formatVideos,SORT_NUMERIC);

        if($this->format and !isset($formatVideos[$this->format])){
            throw new \Exception(sprintf('Format %s is not available. Possible formats are %s',$this->format,implode(', ',array_keys($formatVideos))));
        }
        return $this->format ? $formatVideos[$this->format] : end($formatVideos);
    }

    public function download($destinationFile){
        if(!is_dir(dirname($destinationFile))){
            if(!mkdir(dirname($destinationFile),0777,true)){
                throw new \Exception('Unable to create directory '.dirname($destinationFile));
            }
        }

        $tempFile = $destinationFile.'.temp';
        if(!is_file($tempFile)) {
            file_put_contents($tempFile, (new \DateTime('now'))->format('Y-m-d H:i:s'));
            file_put_contents($destinationFile, file_get_contents($this->getURL()));
            unlink($tempFile);
        }
    }
}