<?php
namespace App\Infrastructure\Scraping;

use Crwlr\Crawler\Crawler;

use Crwlr\Crawler\Loader\Http\HttpLoader;
use Crwlr\Crawler\Loader\LoaderInterface;
use Crwlr\Crawler\UserAgents\BotUserAgent;
use Crwlr\Crawler\UserAgents\UserAgentInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class CrawlerService extends Crawler
{
    protected function userAgent(): UserAgentInterface
    {
        return BotUserAgent::make('botbot');
    }


    protected function loader(UserAgentInterface $userAgent, LoggerInterface $logger): LoaderInterface
    {
        $loader = new HttpLoader($userAgent);
        $loader->dontUseCookies();
        return $loader;
    }

    public function logger(): LoggerInterface
    {
        return new NullLogger();
    }

}
