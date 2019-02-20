<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

// a solution to validate
class MyController
{
    /**
     * @Route("/{format}", name="home", methods={"GET"})
     */
    public function show(
        string $format = 'json',
        Request $request,
        SerializerInterface $serializer
    ): Response
    {
        $data = $this->resolve($request);

        $response = new Response(
            $serializer->serialize($data, $format)
        );
        $response->headers->set(
            'Content-Type',
            sprintf('application/%s', $format)
        );
        // $response->headers->set(
        //     'Content-Disposition',
        //     sprintf('attachment; filename="output.%s"', $format)
        // );

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
        $resolver->setDefault('start', 0)
            ->setAllowedTypes('start', 'int')
            ->setDefault('hello', null)
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