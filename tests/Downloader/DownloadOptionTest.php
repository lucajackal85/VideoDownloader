<?php

namespace Jackal\Downloader\Tests\Downloader;

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

class DownloadOptionTest extends AbstractDownloadTest
{
    public function testDownloaderWithDefaultOptions(){

        $this->assertEquals([
            'video_id' => 123,
            'overwrite' => false,
            'force' => false,
        ], $this->getTestLocalDownloader(123, [])->getOptions());
    }

    public function testDownloaderWithCustomOptions(){
        $this->assertEquals([
            'video_id' => 123,
            'overwrite' => false,
            'force' => false,
            'custom_option' => 'this is the custom option',
        ], $this->getTestLocalDownloader(123, ['custom_option' => 'this is the custom option'])->getOptions());
    }

    public function testRaiseExceptionOnMissingId(){

        $this->expectExceptionMessage(InvalidOptionsException::class);
        $this->expectExceptionMessage('The option "video_id" with value null is expected to be of type "string" or "integer", but is of type "NULL"');

        $this->assertEquals([
            'overwrite' => false,
            'force' => false,
        ], $this->getTestLocalDownloader(null, [])->getOptions());
    }
}