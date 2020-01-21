<?php


namespace App\Model\Movie;

use App\Entity\Movie;

class LongPriceCalculator implements PriceCalculatorInterface {
    public function getPrice(Movie $movie): float {
        return 9.75;
    }
}
