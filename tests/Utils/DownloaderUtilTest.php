<?php

namespace Jackal\Downloader\Tests\Utils;

use Jackal\Downloader\Tests\AbstractFileDownloaderTest;
use Jackal\Downloader\Utils\DownloaderUtil;

class DownloaderUtilTest extends AbstractFileDownloaderTest
{
    public function testCallBack()
    {
        DownloaderUtil::downloadURL(__DIR__ . '/../Sample/sample_1.txt', __DIR__ . '/output.txt', function ($kbRead) {
            $this->assertTrue(true);
            $this->assertIsNumeric($kbRead);
            $this->assertGreaterThan(0, $kbRead);
        });

        $this->removeFileIfExists(__DIR__ . '/output.txt');
    }

    public function testDownload()
    {
        DownloaderUtil::downloadURL(__DIR__ . '/../Sample/sample_1.txt', __DIR__ . '/output.txt');
        $this->assertFileExists(__DIR__ . '/output.txt');
        $this->removeFileIfExists(__DIR__ . '/output.txt');
    }
}
