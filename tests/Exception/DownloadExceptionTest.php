<?php


namespace Jackal\Downloader\Tests\Exception;


use Jackal\Downloader\Exception\DownloadException;
use PHPUnit\Framework\TestCase;

class DownloadExceptionTest extends TestCase
{
    public function testExceptionTempFileExists(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Temp file "thefile.txt" already exists, use force to overwrite');

        throw DownloadException::tempFileAlreadyExists('thefile.txt');
    }

    public function testExceptionAlreadyRegistered(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Downloader with name "MyDownloader" is already registered');

        throw DownloadException::alreadyRegistered('MyDownloader');
    }
}