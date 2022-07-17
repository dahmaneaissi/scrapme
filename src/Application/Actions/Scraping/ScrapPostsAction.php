<?php


namespace App\Application\Actions\Scraping;

use App\Application\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class ScrapPostsAction extends ScrapingAction
{
    private RendererInterface $renderer;

    public function __construct(LoggerInterface $logger, RendererInterface $renderer)
    {
        parent::__construct($logger);
        $this->renderer = $renderer;
        $this->renderer->setLayout('layouts/default.php');
    }

    /**
     * @return RendererInterface
     */
    public function getRenderer(): RendererInterface
    {
        return $this->renderer;
    }

    protected function action(): Response
    {
        return $this->renderer->render($this->response, 'index.php', ['a'=> 'b']);
    }
}
