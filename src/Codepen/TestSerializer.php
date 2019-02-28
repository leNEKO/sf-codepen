<?php

namespace App\Codepen;

if (!debug_backtrace()) {
    include '../../vendor/autoload.php';
}

use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class TestSerializer
{
    public function main()
    {
        $jsonDecoder = new JsonDecode();

        // load data
        $callback = function ($path) use ($jsonDecoder) {
            $content = file_get_contents($path);
            try {
                $result = $jsonDecoder->decode($content, JsonEncoder::FORMAT);

                return $result;
            } catch (\Exception $e) {
                return sprintf(
                    'invalid json file: %s',
                    $path
                );
            }
        };
        $data = array_map($callback, glob('data/*.json*'));

        var_dump($data);
    }
}

if (!debug_backtrace()) {
    (new TestSerializer())->main();
}
