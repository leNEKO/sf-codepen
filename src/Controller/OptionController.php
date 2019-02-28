<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OptionController
{
    /**
     * @Route("/my/{format}", name="home", methods={"GET"})
     */
    public function show(
        string $format = 'json',
        Request $request,
        SerializerInterface $serializer
    ): Response {
        $data = $this->resolve($request);

        $response = new Response(
            $serializer->serialize($data, $format)
        );
        $response->headers->set(
            'Content-Type',
            sprintf('application/%s', $format)
        );

        return $response;
    }

    private function resolve(Request $request): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        return $resolver->resolve(
            $this->normalizeIntegers(
                $request->query->all()
            )
        );
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
            'start' => 0,
            'hello' => null,
            ]
        );

        $resolver
            ->setAllowedTypes('start', 'int')
            ->setAllowedTypes('hello', ['null', 'int', 'string']);
    }

    private function normalizeIntegers(array $parameters): array
    {
        $normalized = [];

        foreach($parameters as $key => $value){
            $normalized[$key] = is_numeric($value) ? (int) $value : $value;
        }

        return $normalized;
    }
}