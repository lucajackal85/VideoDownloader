<?php

namespace Jackal\Downloader\Downloader;

use Jackal\Downloader\Exception\DownloadException;
use Jackal\Downloader\Utils\DownloaderUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractDownloader implements DownloaderInterface
{
    /**
     * @var string
     */
    protected $tempFilePathName;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * AbstractDownloader constructor.
     * @param $id
     * @param array $config
     */
    public function __construct($id, $config = [])
    {
        $options = new OptionsResolver();
        $options->setDefaults(array_merge($config,[
            'force' => false,
            'video_id' => $id,
            'overwrite' => false
        ]));

        $options->setAllowedTypes('force', 'bool');
        $options->setAllowedTypes('overwrite', 'bool');
        $options->setAllowedTypes('video_id', 'string');
        $this->options = $options->resolve($config);
    }

    /**
     * @return mixed
     */
    protected function forceDownload(){
        return $this->options['force'] == true;
    }

    /**
     * @return bool
     */
    protected function forceOverwriteFile(){
        return $this->options['overwrite'] == true;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    protected function getVideoId() : string {
        return $this->options['video_id'];
    }

    /**
     * @param $destinationFile
     * @throws DownloadException
     */
    public function download($destinationFile) : void {

        if(file_exists($destinationFile) and !$this->forceOverwriteFile()){
            throw new \Exception(sprintf('Output file "%s" already exists. Use option `overwrite` to force',$destinationFile));
        }

        if(!is_dir(dirname($destinationFile))){
            if(!mkdir(dirname($destinationFile), 0777, true)){
                throw new \Exception('Unable to create directory ' . dirname($destinationFile));
            }
        }

        $this->tempFilePathName = $destinationFile . '.temp';

        if(file_exists($this->tempFilePathName) and !$this->forceDownload()){
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
}