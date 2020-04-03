<?php

namespace Jackal\Downloader\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractFileDownloaderTest extends TestCase
{
    protected function removeFileIfExists($fileName)
    {
        if (is_file($fileName)) {
            unlink($fileName);
        }
    }
}
