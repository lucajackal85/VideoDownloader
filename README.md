# VideoDownloader
[![Latest Stable Version](https://poser.pugx.org/jackal/video-downloader/v/stable)](https://packagist.org/packages/jackal/video-downloader)
[![Total Downloads](https://poser.pugx.org/jackal/video-downloader/downloads)](https://packagist.org/packages/jackal/video-downloader)
[![Latest Unstable Version](https://poser.pugx.org/jackal/video-downloader/v/unstable)](https://packagist.org/packages/jackal/video-downloader)
[![License](https://poser.pugx.org/jackal/video-downloader/license)](https://packagist.org/packages/jackal/video-downloader)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lucajackal85/VideoDownloader/?branch=master)

## This is the base project for actual downloader projects:
- [jackal/video-downloader-ext-vimeo](https://github.com/lucajackal85/VideoDownloaderVimeoExtension)
- [jackal/video-downloader-ext-youtube](https://github.com/lucajackal85/VideoDownloaderYoutubeExtension)

## Installation
```
    composer require jackal/video-downloader
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
}
```

### Download it!
```
$myVideoIdOrReference = 'video-123456';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader('my_downloader', MyDownloader::class);

$downloader = $vd->getDownloader('my_downloader', $myVideoIdOrReference, [
    //[...additional custom options...]
]);

$downloader->download(__DIR__ . '/output.avi');
```
