<?php
declare(strict_types=1);

use App\Application\Renderer\RendererInterface;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        RendererInterface::class =>  function (ContainerInterface $container) {
            $PhpRenderer = new PhpRenderer($container->get(SettingsInterface::class)->get('views')['path']);
            return new App\Application\Renderer\PhpRenderer($PhpRenderer);
        },
        CacheItemPoolInterface::class => function () {
            return new FilesystemAdapter();
        }
    ]);
};
