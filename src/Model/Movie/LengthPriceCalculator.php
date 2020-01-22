<?php


namespace App\Model\Movie;

use App\Entity\Movie;

class LengthPriceCalculator extends DefaultPriceCalculator implements PriceCalculatorInterface {
    public function getPrice(Movie $movie): float {
        if(!$movie->getRuntime()){
            return parent::getPrice($movie);
        }

        if($movie->getRuntime() <= 90){
            return 6.00;
        }
        elseif($movie->getRuntime() > 90 && $movie->getRuntime() <= 140) {
            return parent::getPrice($movie);
        }
        else {
            return 9.75;
        }
    }
}
