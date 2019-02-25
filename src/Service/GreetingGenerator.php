<?php
declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Twig\Extension\AbstractExtension;

class GreetingGenerator
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getRandomGreeting(): string
    {
        $greetings = [
            'Hey', 'Yo', 'Aloha',
            'Hello', 'Salut'
        ];
        $greeting = $greetings[array_rand($greetings)];
        $this->logger->info(sprintf('Using the greeting: %s', $greeting));

        return $greeting;
    }
}