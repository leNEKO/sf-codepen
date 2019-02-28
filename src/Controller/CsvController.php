<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class CsvController
{
    const MAX = 2**20; // max lines

    /**
     * @Route("/csv/{qty}")
     */
    public function output(int $qty = 1000): StreamedResponse
    {
        if($qty >= self::MAX) {
            throw new \Exception(
                sprintf(
                    'Excel/LibreOffice cannot read more than %s lines per csv file',
                    self::MAX
                )
            );
        }

        // no limit
        set_time_limit(0);

        $filename = sprintf('output-%s.csv', $qty);

        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set(
            'Content-Disposition',
            sprintf('attachment; filename="%s"', $filename)
        );

        // do the stuff line by line
        $callback = function () use ($qty) {
            $fh = fopen('php://output', 'r+');
            fputcsv($fh, ['key', 'value']);

            for($i = 0; $i < $qty; $i++)
            {
                fputcsv($fh, [$i, $qty - $i]);
            }

            fclose($fh);
        };

        $response->setCallback($callback);

        return $response;
    }
}