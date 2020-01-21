<?php


namespace App\Model\Movie;

use App\Entity\Movie;

class KidsPriceCalculator implements PriceCalculatorInterface {
    public function getPrice(Movie $movie): float {
        return 5.25;
    }
}