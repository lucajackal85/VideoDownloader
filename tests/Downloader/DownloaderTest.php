<?php


namespace Jackal\Downloader\Tests\Downloader;

use Jackal\Downloader\Exception\DownloadException;

class DownloaderTest extends AbstractDownloadTest
{

    public function testDownloadFile(){
        $this->removeFileIfExists(__DIR__.'/output.txt');
        $this->getTestLocalDownloader('123',[])->download(__DIR__.'/output.txt');
        $this->assertFileExists(__DIR__.'/output.txt');

        $this->removeFileIfExists(__DIR__.'/output.txt');
    }

    public function testRaiseExceptionOnOverwrite(){

        $this->expectException(DownloadException::class);
        $this->expectExceptionMessage('Output file "'.__DIR__.'/output.txt" already exists. Use option `overwrite` to force');

        file_put_contents(__DIR__.'/output.txt','the content');
        $this->getTestLocalDownloader('123',[])->download(__DIR__.'/output.txt');
        $this->assertFileExists(__DIR__.'/output.txt');

        $this->removeFileIfExists(__DIR__.'/output.txt');
    }

    public function testDONOTRaiseExceptionOnOverwrite(){

        $content = rand(1000000,9999999);
        file_put_contents(__DIR__.'/output.txt',$content);
        $this->getTestLocalDownloader('123',[
            'overwrite' => true
        ])->download(__DIR__.'/output.txt');
        $this->assertFileExists(__DIR__.'/output.txt');
        $this->assertEquals('ciao',file_get_contents(__DIR__.'/output.txt'));

        $this->removeFileIfExists(__DIR__.'/output.txt');
    }

    protected function removeFileIfExists($fileName){
        if(is_file($fileName)){
            unlink($fileName);
        }
    }
}