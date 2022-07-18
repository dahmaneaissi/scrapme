<?php
namespace Tests\Infrastructure\Scraping;

use App\Infrastructure\Scraping\CrawlerService;
use App\Infrastructure\Scraping\PostRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    private PostRepository $scrapingRepository;
    const POSTS_URLS = 'https://www.elwatan.com/category/edition/international';
    protected function setUp(): void
    {
        $scrapingService = new CrawlerService();
        $cache = new FilesystemAdapter('', 3600, __DIR__ . '/cache');
        $this->scrapingRepository = new PostRepository($scrapingService, $cache);
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testGetPostsByUrl()
    {
        $posts = $this->scrapingRepository->getPostsByUrl(self::POSTS_URLS, '.title-14 a');
        $this->assertIsArray($posts);
    }
}
