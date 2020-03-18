# Video Downloader
Minimal example
```
use Jackal\Downloader\Downloader\DownloaderFactory;

require_once __DIR__.'/vendor/autoload.php';

$youtubeVideoId = 'otCpCn0l4Wo';

$downloader = DownloaderFactory::getInstance(DownloaderFactory::TYPE_YOUTUBE,$youtubeVideoId);
$downloader->download(__DIR__.'/output/'.$youtubeVideoId.'.avi');
```