<?php


namespace App\Model\Movie;

use App\Model\Movie\PriceCalculatorInterface;


class PriceCalculatorFactory {


    /**
     * Factory Design Pattern
     *
     * @return \App\Model\Movie\PriceCalculatorInterface
     */
    public function createPriceCalculator($priceType): PriceCalculatorInterface {
        if(!empty($priceType)){
            $priceCalculatorClass = "\\App\\Model\\Movie\\" . ucfirst($priceType) . "PriceCalculator";
            if(class_exists($priceCalculatorClass)) {
                return new $priceCalculatorClass();
            }
        }
        return new DefaultPriceCalculator();
    }
}