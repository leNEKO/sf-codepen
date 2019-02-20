<?php
declare(strict_types=1);

namespace App\Twig;

use App\Greeting\GreetingGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GreetExtension extends AbstractExtension
{
    private $generator;

    public function __construct(GreetingGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('greet', [$this, 'greetUser']),
        ];
    }

    public function greetUser(string $name)
    {
        $greeting = $this->generator->getRandomGreeting();

        return sprintf('%s, %s!', $greeting, $name);
    }
}