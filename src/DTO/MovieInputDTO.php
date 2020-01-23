<?php


namespace App\DTO;

/**
 * Class MovieInputDTO
 * @package App\Application\DTO
 */
final class MovieInputDTO {

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $genre;

    /**
     * @var date
     */
    private $released;

    /**
     * @var string
     */
    private $priceType;

    /**
     * @var string
     */
    private $imdbID;


    /**
     * MovieInputDTO constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct(string $title = '', int $genre = null, string $released, string $priceType = null, $imdbID = null) {
        $this->title = $title;
        $this->genre = $genre;
        $this->released = $released;
        $this->priceType = $priceType ?? 'default';
        $this->imdbID = $imdbID;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @return int§
     */
    public function getGenre(): string {
        return $this->genre;
    }

    /**
     * @return string
     */
    public function getReleased(): string {
        return $this->released;
    }

    /**
     * @return string
     */
    public function getPriceType(): string {
        return $this->priceType;
    }

    /**
     * @return string
     */
    public function getImdbID(): string {
        return $this->imdbID;
    }
}