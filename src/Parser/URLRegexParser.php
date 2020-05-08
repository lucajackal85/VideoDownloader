<?php


namespace Jackal\Downloader\Parser;

class URLRegexParser
{
    protected $downloaderClass;

    public function __construct(string $downloaderClass)
    {
        $this->downloaderClass = $downloaderClass;
    }

    /**
     * @param string $publicWatchUrl
     * @return string|null
     */
    public function parse(string $publicWatchUrl) : ?string{
        preg_match($this->downloaderClass::getPublicUrlRegex(),$publicWatchUrl,$matches);
        if(isset($matches[1])){
            return $matches[1];
        }

        return null;
    }

    /**
     * @param string $publicWatchUrl
     * @return bool
     */
    public function isValidUrl(string $publicWatchUrl) : bool {
        return $this->parse($publicWatchUrl) == true;
    }
}