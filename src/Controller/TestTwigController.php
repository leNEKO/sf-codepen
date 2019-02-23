<?php
declare(strict_types=1);

namespace App\Controller;

use App\Greeting\GreetingGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestTwigController extends AbstractController
{
    /**
     * @Route("/{name}")
     */
    public function index(
        string $name = "world",
        LoggerInterface $logger,
        GreetingGenerator $generator
    ): Response
    {
        $str = sprintf(
            '%s, %s !',
            $generator->getRandomGreeting(),
            $name
        );
        $logger->info($str);

        return $this->render('index.html.twig',[
            'name' => $name
        ]);
    }
}