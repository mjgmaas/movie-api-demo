<?php


namespace App\Tests\Model;

use App\Entity\Movie;
use App\Model\Movie\DefaultPriceCalculator;
use App\Model\Movie\LengthPriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    public function testDefaultPriceCalculator()
    {
        $movieEntity = new Movie();

        $calculator = new DefaultPriceCalculator();
        $result = $calculator->getPrice($movieEntity);

        $this->assertEquals(7.75, $result);
    }

    public function testLengthPriceCalculatorForShortMovie()
    {
        $movieEntity = new Movie();
        $movieEntity->setRuntime(80);

        $calculator = new LengthPriceCalculator();
        $result = $calculator->getPrice($movieEntity);

        $this->assertEquals(6, $result);
    }

    public function testLengthPriceCalculatorForLongMovie()
    {
        $movieEntity = new Movie();
        $movieEntity->setRuntime(160);

        $calculator = new LengthPriceCalculator();
        $result = $calculator->getPrice($movieEntity);

        $this->assertEquals(9.75, $result);
    }
}