<?php
declare(strict_types=1);

namespace App\Application\Actions\Scraping;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class ScrapingAction extends Action
{
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }
}
