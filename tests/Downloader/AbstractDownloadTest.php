<?php


namespace Jackal\Downloader\Tests\Downloader;


use Jackal\Downloader\Downloader\AbstractDownloader;
use PHPUnit\Framework\TestCase;

abstract class AbstractDownloadTest extends TestCase
{
    protected function getTestLocalDownloader($id,$config){
        return new class($id,$config) extends AbstractDownloader{

            public function getURL() : string{
                return __DIR__.'/../Sample/sample_1.txt';
            }

        };
    }
}