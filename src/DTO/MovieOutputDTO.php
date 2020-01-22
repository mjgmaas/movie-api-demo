<?php


namespace App\DTO;

use App\Model\Movie\DefaultPriceCalculator;
use App\Model\Movie\PriceCalculatorInterface;

/**
 * Class MovieInputDTO
 * @package App\Application\DTO
 */
final class MovieOutputDTO {

    /**
     * @var integer§
     */
    private $id;


    /**
     * @var string
     */
    private $title;

    /**
     * @var GenreOutputDTO
     */
    private $genre;

    /**
     * @var date
     */
    private $released;


    /**
     * @var float
     */
    private $price;

    /**
     * @var integer§
     */
    private $runtime;

    /**
     * MovieInputDTO constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct(int $id, string $title = '',  GenreOutputDTO $genre = null, \DateTimeInterface $released = null, float $price, ?int $runtime) {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->released = $released;
        $this->price = $price;
        $this->runtime = $runtime;

    }

    /**
     * Simple Strategy Design Pattern
     *
     * @return \App\Model\Movie\PriceCalculatorInterface
     */
    private function getPriceCalculator(): PriceCalculatorInterface {
        if(!empty($this->priceType)){
            $priceCalculatorClass = "\\App\\Model\\Movie\\" . ucfirst($this->priceType) . "PriceCalculator";
            if(class_exists($priceCalculatorClass)) {
                return new $priceCalculatorClass();
            }
        }
        return new DefaultPriceCalculator();
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return GenreOutputDTO
     */
    public function getGenre(): GenreOutputDTO {
        return $this->genre;
    }

    /**
     * @return \DateTime
     */
    public function getReleased(): \DateTimeInterface {
        return $this->released;
    }

    /**
     * @return float
     */
    public function getPrice(): float {
        return $this->price;
    }
}