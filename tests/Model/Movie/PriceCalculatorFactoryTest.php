<?php


namespace App\Tests\Model;

use App\Entity\Movie;
use App\Model\Movie\PriceCalculatorFactory;
use PHPUnit\Framework\TestCase;

class PriceCalculatorFactoryTest extends TestCase
{
    public function testPriceCalculatorFactoryCreatesKidsPriceCalculator()
    {
        $movieEntity = new Movie();
        $movieEntity->setPriceType('kids');

        $calculatorFactoruy = new PriceCalculatorFactory();
        $calculator = $calculatorFactoruy->createPriceCalculator($movieEntity->getPriceType());

        $result = $calculator->getPrice($movieEntity);

        $this->assertEquals(5.25, $result);
    }
}