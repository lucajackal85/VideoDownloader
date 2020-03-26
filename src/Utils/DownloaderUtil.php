<?php

namespace Jackal\Downloader\Utils;

class DownloaderUtil
{
    public static function downloadURL($url, $outfile) {

        $rh = fopen($url, 'rb');
        $wh = fopen($outfile, 'wb');
        if ($rh === false || $wh === false) {
// error reading or opening file
            return true;
        }
        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 1024)) === FALSE) {
                // 'Download error: Cannot write to file ('.$file_target.')';
                return true;
            }
        }
        fclose($rh);
        fclose($wh);
        // No error
        return false;
    }
}