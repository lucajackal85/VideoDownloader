<?php

namespace Jackal\Downloader\Tests\Downloader;

use Jackal\Downloader\Exception\DownloadException;
use PHPUnit\Framework\TestCase;

class DownloaderWithFormatsFilterTest extends AbstractDownloadTest
{
    public function testGetFormatsFilterDefaults(){

        $downloader = $this->getTestLocalDownloader('id', []);

        $method = new \ReflectionMethod(get_class($downloader), 'filterByFormats');
        $method->setAccessible(true);
        $getFormats = $method->invoke($downloader, [
            480 => 'b', 360 => 'a',
        ]);

        $this->assertEquals([360 => 'a',480 => 'b'], $getFormats);
    }

    public function testGetFormatsFilter(){

        $downloader = $this->getTestLocalDownloader('id', [
            'format' => 360,
        ]);

        $method = new \ReflectionMethod(get_class($downloader), 'filterByFormats');
        $method->setAccessible(true);
        $getFormats = $method->invoke($downloader, [
            480 => 'b', 360 => 'a',
        ]);

        $this->assertEquals([360 => 'a'], $getFormats);
    }

    public function testItShouldRaiseExceptionOnFormatNotFound(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Format 1080 is not available. [Available formats are: 360, 480]');

        $downloader = $this->getTestLocalDownloader('id', [
            'format' => 1080,
        ]);

        $method = new \ReflectionMethod(get_class($downloader), 'filterByFormats');
        $method->setAccessible(true);
        $method->invoke($downloader, [
            360 => 'a', 480 => 'b',
        ]);
    }
}