# VideoDownloader
[![Latest Stable Version](https://poser.pugx.org/jackal/video-downloader/v/stable)](https://packagist.org/packages/jackal/video-downloader)
[![Total Downloads](https://poser.pugx.org/jackal/video-downloader/downloads)](https://packagist.org/packages/jackal/video-downloader)
[![Latest Unstable Version](https://poser.pugx.org/jackal/video-downloader/v/unstable)](https://packagist.org/packages/jackal/video-downloader)
[![License](https://poser.pugx.org/jackal/video-downloader/license)](https://packagist.org/packages/jackal/video-downloader)
[![Build Status](https://travis-ci.org/lucajackal85/VideoDownloader.svg?branch=master)](https://travis-ci.org/lucajackal85/VideoDownloader)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloader/?branch=master)

## This is the base project for actual downloader projects:
- [jackal/video-downloader-ext-vimeo](https://github.com/lucajackal85/VideoDownloaderVimeoExtension)
- [jackal/video-downloader-ext-youtube](https://github.com/lucajackal85/VideoDownloaderYoutubeExtension)

## Installation
```
    composer require jackal/video-downloader:^0.5
```
### Write your own downloader:
```
class MyDownloader extends AbstractDownloader
{
    public function getURL(): string
    {
       $videoId = $this->getVideoId();
       
       //$videoLocation = [...code to retreive URL ...]

       return $videoLocation;
    }
    
    //it needs to identify video ID from public URLS (this example: http://www.sample-site.com/video/1234/)
    public static function getPublicUrlRegex(): string
    {
        return '/www\.sample-site\.com\/video\/([\d]+)\//';
    }

    public static function getType(): string
    {
        return 'my_downloader';
    }
}
```

### Download it!
```
$myVideoIdOrReference = '123456';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(MyDownloader::class);

$downloader = $vd->getDownloader('my_downloader', $myVideoIdOrReference, [
    //[...additional custom options...]
]);

$downloader->download(__DIR__ . '/output.avi');
```
### Download from URL
```
$myVideoIdOrReference = '123456';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(MyDownloader::class);

$downloader = $vd->getDownloaderByPublicUrl('http://www.sample-site.com/video/1234/', [
    //[...additional custom options...]
]);

$downloader->download(__DIR__ . '/output.avi');
```
