# Video Downloader

## This is the base project for actual downloader projects:
- [jackal/video-downloader-ext-vimeo](https://github.com/lucajackal85/VideoDownloaderVimeoExtension)
- [jackal/video-downloader-ext-youtube](https://github.com/lucajackal85/VideoDownloaderYoutubeExtension)

## Installation
```
    composer install jackal/video-downloader
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
