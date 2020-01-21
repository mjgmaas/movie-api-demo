<?php


namespace App\Model\Movie;

use App\Entity\Movie;

class DefaultPriceCalculator implements PriceCalculatorInterface {
    public function getPrice(Movie $movie): float {
        return 7.75;
    }
}