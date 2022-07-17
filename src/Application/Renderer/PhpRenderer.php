<?php
namespace App\Application\Renderer;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer as PhpPurRenderer;
use Throwable;

class PhpRenderer implements RendererInterface
{
    private PhpPurRenderer $renderer;

    public function __construct(PhpPurRenderer $phpRenderer)
    {
        $this->renderer = $phpRenderer;
    }

    /**
     * @param ResponseInterface $response
     * @param string $template
     * @param array $data
     * @return ResponseInterface
     * @throws Throwable
     */
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        return $this->renderer->render($response, $template, $data = []);
    }

    public function setLayout(string $layout): void
    {
        $this->renderer->setLayout($layout);
    }

}
