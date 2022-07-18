<?php


namespace App\Infrastructure\Scraping;

use Crwlr\Crawler\Result;
use Crwlr\Crawler\Steps\Html;
use Crwlr\Crawler\Steps\Loading\Http;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class PostRepository implements PostRepositoryInterface
{
    private CrawlerService $crawlerService;

    private $cache;

    public function __construct(CrawlerService $crawlerService, CacheItemPoolInterface $cache)
    {
        $this->crawlerService = $crawlerService;
        $this->cache = $cache;
    }

    /**
     * @return CrawlerService
     */
    public function getCrawlerService(): CrawlerService
    {
        return $this->crawlerService;
    }

    /**
     * @throws InvalidArgumentException
     * @throws \Exception
     */
    public function getPostsByUrl(string $url, string $selector) : array
    {
        $postsItem = $this->cache->getItem('posts.all');

        if (!$postsItem->isHit()) {
            $this->crawlerService->inputs([ $url ]);
            $this->crawlerService->addStep(Http::get())
                ->addStep(Html::getLinks($selector))
                ->addStep(Http::get())
                ->addStep(
                    Html::each('article')
                        ->extract([
                            'title' => 'h1',
                            'content' => '.texte'
                        ])
                );

            $data = [];
            /* @var $result  Result */
            foreach ($this->crawlerService->run() as $result) {
                $data[] = $result->get('unnamed');
            }

            $postsItem->set($data);
            $this->cache->save($postsItem);
            return $data;
        }

        return $postsItem->get();
    }
}
