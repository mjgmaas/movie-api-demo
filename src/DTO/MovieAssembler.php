<?php


namespace App\DTO;


use App\Adapter\ImdbConnector;
use App\Adapter\OmdbWebserviceAdapter;
use App\DTO\MovieInputDTO;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityNotFoundException;
use App\Model\Movie\PriceCalculatorFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MovieAssembler
 * @package App\Application\DTO
 */
final class MovieAssembler
{
    private $genreRepository;
    private $priceCalculatorFactory;
    private $ImdbWebservice;

    public function __construct(GenreRepository $genreRepository,
                                PriceCalculatorFactory $priceCalculatorFactory,
                                ImdbConnector $imdbConnector

    ) {
        $this->genreRepository = $genreRepository;
        $this->priceCalculatorFactory = $priceCalculatorFactory;
        $this->ImdbWebservice = $imdbConnector;
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
        $movie->setPriceType($movieDTO->getPriceType());
        $movie->setImdbID($movieDTO->getImdbID());

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

    private function getMovieRuntime(Movie $movie) {
        if(!$movie->getRuntime() && $movie->getImdbID()){
            try{
                $movieData = $this->ImdbWebservice->getMovie($movie->getImdbID());
            }
            catch (NotFoundHttpException $e){
                return null;
            }
            preg_match('/\d+/', $movieData['Runtime'], $matches);
            if(count($matches) && is_numeric( $matches[0])) {
                return  $matches[0];
            }
        }
        return null;
    }

    public function createMovieOutputDTO(Movie $movie)
    {
        /**
         * @var PriceCalculatorInterface
         */
        $priceCalculator = $this->priceCalculatorFactory->createPriceCalculator($movie->getPriceType());

        $runtime = $this->getMovieRuntime($movie);
        $movie->setRuntime($runtime);

        return new MovieOutputDTO(
            $movie->getId(),
            $movie->getTitle(),
            new GenreOutputDTO($movie->getGenre()->getId(), $movie->getGenre()->getName()),
            $movie->getReleased(),
            $priceCalculator->getPrice($movie),
            $runtime
        );
    }

}
