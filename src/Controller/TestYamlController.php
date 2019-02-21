<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class TestController extends AbstractController
{

    /**
     * @Route("/yaml/{file}")
     */
    public function index(string $file)
    {

        $path = sprintf('%s/%s', __DIR__, 'hello.yaml');
        $hello = Yaml::parse(file_get_contents($path));
        var_dump($hello);

        $title = $path;
        $body = __DIR__;

        return $this->render('home.html.twig',[
            'title' => $title,
            'body' => $body,
        ]);
    }
}
