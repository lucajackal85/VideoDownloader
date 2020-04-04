<?php

namespace Jackal\Downloader\Tests\Downloader;

use Jackal\Downloader\Downloader\AbstractDownloaderWithFormats;
use PHPUnit\Framework\TestCase;

class DownloaderWithFormatsTest extends AbstractDownloadTest
{

    public function testGetFormatsDefault(){

        $downloader = $this->getTestLocalDownloader('id', []);

        $method = new \ReflectionMethod(get_class($downloader), 'getFormats');
        $method->setAccessible(true);
        $getFormats = $method->invoke($downloader);

        $this->assertEquals([], $getFormats);

    }

    public function testGetFormatsString(){

        $downloader = $this->getTestLocalDownloader('id', [
            'format' => 'string',
        ]);

        $method = new \ReflectionMethod(get_class($downloader), 'getFormats');
        $method->setAccessible(true);
        $getFormats = $method->invoke($downloader);

        $this->assertEquals(['string'], $getFormats);
    }

    public function testGetFormatsArray(){

        $downloader = $this->getTestLocalDownloader('id', [
            'format' => ['string'],
        ]);

        $method = new \ReflectionMethod(get_class($downloader), 'getFormats');
        $method->setAccessible(true);
        $getFormats = $method->invoke($downloader);

        $this->assertEquals(['string'], $getFormats);
    }
}