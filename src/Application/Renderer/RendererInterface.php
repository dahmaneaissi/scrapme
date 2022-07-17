<?php
namespace App\Application\Renderer;

use Psr\Http\Message\ResponseInterface;

interface RendererInterface
{
    public function render(ResponseInterface $response, string $template, array $data = []) : ResponseInterface;

    public function setLayout(string $layout);
}
