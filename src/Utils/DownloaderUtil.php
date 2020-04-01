<?php

namespace Jackal\Downloader\Utils;

class DownloaderUtil
{
    public static function downloadURL($url, $outfile, ?callable $callback = null) : void {
        $rh = fopen($url, 'rb');
        $wh = fopen($outfile, 'wb');
        if ($rh === false || $wh === false) {
            throw new \Exception('Error opening file');
        }
        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 1024)) === FALSE) {
                throw new \Exception('Cannot write to file (' . $outfile . ')');
            }
            if($callback !== null) {
                $callback();
            }
        }
        fclose($rh);
        fclose($wh);
    }
}