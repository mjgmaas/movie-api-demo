<?php


namespace App\DTO;


use App\DTO\MovieInputDTO;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityNotFoundException;
use App\Model\Movie\PriceCalculatorFactory;

/**
 * Class MovieAssembler
 * @package App\Application\DTO
 */
final class MovieAssembler
{
    private $genreRepository;
    private $priceCalculatorFactory;

    public function __construct(GenreRepository $genreRepository, PriceCalculatorFactory $priceCalculatorFactory) {
        $this->genreRepository = $genreRepository;
        $this->priceCalculatorFactory = $priceCalculatorFactory;
    }


    /**
     * @param MovieInputDTO $movieDTO
     * @param Movie|null $movie
     * @return Movie
     */
    public function readDTO(MovieInputDTO $movieDTO, ?Movie $movie = null): Movie
    {
        if (!$movie) {
            $movie = new Movie();
        }

        $genre = $this->genreRepository->find($movieDTO->getGenre());
        if (!$genre) {
            throw new EntityNotFoundException('Genre with id '.$movieDTO->getGenre().' does not exist!');
        }
        $movie->setTitle($movieDTO->getTitle());
        $movie->setGenre($genre);
        $movie->setReleased(new \DateTime($movieDTO->getReleased()));

        return $movie;
    }

    /**
     * @param Movie $movie
     * @param MovieInputDTO $movieDTO
     * @return Movie
     */
    public function updateMovie(Movie $movie, MovieInputDTO $movieDTO): Movie
    {
        return $this->readDTO($movieDTO, $movie);
    }

    /**
     * @param MovieInputDTO $movieDTO
     * @return Movie
     */
    public function createMovie(MovieInputDTO $movieDTO): Movie
    {
        return $this->readDTO($movieDTO);
    }

    /**
     * @param Movie $movie
     * @return MovieInputDTO
     */
    public function writewDTO(Movie $movie)
    {

        return new MovieInputDTO(
            $movie->getTitle(),
            $movie->getGenre()->getId(),
            $movie->getReleased()

        );
    }

    public function createMovieOutputDTO(Movie $movie)
    {
        /**
         * @var PriceCalculatorInterface
         */
        $priceCalculator = $this->priceCalculatorFactory->createPriceCalculator($movie->getPriceType());

        return new MovieOutputDTO(
            $movie->getId(),
            $movie->getTitle(),
            new GenreOutputDTO($movie->getGenre()->getId(), $movie->getGenre()->getName()),
            $movie->getReleased(),
            $priceCalculator->getPrice($movie)
        );
    }

}
