<?php


namespace Jackal\Downloader\Tests;


use Jackal\Downloader\Downloader\DownloaderInterface;
use Jackal\Downloader\Exception\DownloadException;
use Jackal\Downloader\Tests\Downloader\AbstractDownloadTest;
use Jackal\Downloader\VideoDownloader;

class VideoDownloaderTest extends AbstractDownloadTest
{
    public function testRegisterDownloaderClass(){

        $local = $this->getTestLocalDownloader('123456',[]);

        $downloader = new VideoDownloader();
        $downloader->registerDownloader(get_class($local));

        $this->assertEquals([
            'local_test' => get_class($local)
        ],$downloader->getRegisteredDownloaders());
    }

    public function testGetDownloader(){

        $local = $this->getTestLocalDownloader(123456,[]);

        $downloader = new VideoDownloader();
        $downloader->registerDownloader(get_class($local));

        $this->assertEquals($local,$downloader->getDownloader('local_test',123456));
    }

    public function testItShouldRaiseExeptionOnDownloaderNotFound(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Downloader type "invalid" not found');

        $downloader = new VideoDownloader();
        $downloader->getDownloader('invalid',1234);
    }

    public function testGetDownloaderByUrl(){

        $local = $this->getTestLocalDownloader('this_is_the_url',[]);

        $downloader = new VideoDownloader();
        $downloader->registerDownloader($local);

        $this->assertEquals(
            $local,
            $downloader->getDownloaderByPublicUrl('local_this_is_the_url')
        );
    }


    public function testInRaiseExceptionOnDownloaderNotFoundPublicUrl(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Downloader not found [trying to parse: invalid_url]');

        $downloader = new VideoDownloader();
        $downloader->getDownloaderByPublicUrl('invalid_url');
    }
}