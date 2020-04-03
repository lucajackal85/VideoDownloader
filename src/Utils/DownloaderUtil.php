<?php

namespace Jackal\Downloader\Utils;

use Jackal\Downloader\Exception\DownloadException;

class DownloaderUtil
{
    /**
     * @param string $url
     * @param string $outfile
     * @param callable|null $callback
     * @throws DownloadException
     */
    public static function downloadURL(string $url, string $outfile, ?callable $callback = null) : void
    {
        if (($rh = fopen($url, 'rb')) === false) {
            throw DownloadException::downloadError('Error opening file: ' . $url);
        }

        if(($wh = fopen($outfile, 'wb')) === false){
            throw DownloadException::downloadError('Error creating file: ' . $outfile);
        }

        $kbRead = 0;
        while (!feof($rh)) {
            $kbRead++;
            if (fwrite($wh, fread($rh, 1024)) === false) {
                throw DownloadException::downloadError('Cannot write to file: ' . $outfile);
            }
            if ($callback !== null) {
                $callback($kbRead);
            }
        }
        fclose($rh);
        fclose($wh);
    }
}
