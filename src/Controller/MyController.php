<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

// a solution to validate
class MyController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function show(Request $request): JsonResponse
    {
        $data = $this->resolve($request);

        return new JsonResponse($data);
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