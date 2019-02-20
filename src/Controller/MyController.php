<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    public function resolve(Request $request): array
    {
        $normalized = $this->normalizeIntegers(
            $request->query->all()
        );

        return (new OptionsResolver())
            ->setDefault('start', 0)
            ->setAllowedTypes('start', 'int')
            ->setDefault('hello', null)
            ->setAllowedTypes('hello', ['null', 'int', 'string'])
            ->resolve($normalized);
    }

    public function normalizeIntegers(array $parameters): array
    {
        $normalized = [];

        foreach($parameters as $key => $value){
            $normalized[$key] = is_numeric($value) ? (int) $value : $value;
        }

        return $normalized;
    }
}