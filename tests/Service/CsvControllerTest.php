<?php
namespace App;

use App\Controller\CsvController;
use PHPUnit\Framework\TestCase;

class CsvControllerTest extends TestCase
{
    public function testDump(): void
    {
        $csvController = new CsvController();
        $data = $csvController->output(10);
    }
}