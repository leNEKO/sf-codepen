<?php
declare(strict_types=1);
namespace App\Controller;

use App\Service\GreetingGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/{name}")
     */
    public function index(
        string $name = "world",
        LoggerInterface $logger,
        GreetingGenerator $generator
    ): Response {
        $str = sprintf(
            '%s, %s !',
            $generator->getRandomGreeting(),
            $name
        );
        $logger->info($str);

        return $this->render(
            'index.html.twig', [
            'name' => $name
            ]
        );
    }

    /**
     * @Route ("/api/v1/{name}")
     */
    public function api(
        string $name,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = [
            'hello' => 'world'
        ];

        $encoded = $serializer->serialize($data, 'json');

        $decoded = $serializer->deserialize($encoded, 'ArrayObject', 'json');

        return new JsonResponse($decoded);
    }
}
