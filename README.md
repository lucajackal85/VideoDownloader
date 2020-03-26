## Disclaimer: this library is in Alpha - not tester. Use it at your own risk!

# Video Downloader
Minimal example
```
$youtubeVideoId = 'otCpCn0l4Wo';

$vd = new \Jackal\Downloader\VideoDownloader();
$downloader = $vd->getDownloader(VideoDownloader::TYPE_YOUTUBE,$youtubeVideoId);

$downloader->download('/path/to/output/file.avi');
```
