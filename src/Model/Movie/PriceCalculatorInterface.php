<?php


namespace App\Model\Movie;

use App\Entity\Movie;


interface PriceCalculatorInterface {
    /**
     * @param \App\Entity\Movie $movie
     * @return float
     */
    public function getPrice(Movie $movie): float;
}