<?php

namespace App\Controller;

use App\Entity\Movie;
use App\DTO\MovieInputDTO;
use App\DTO\MovieAssembler;
use App\Repository\MovieRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;



/**
 * Movie service controller.
 * @Route("/api", name="api_")
 */
class MovieServiceController extends AbstractFOSRestController {


    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * @var MovieAssembler
     */
    private $movieAssembler;

    /**
     * MovieController constructor.
     * @param MovieRepository $movieRepository
     */
    public function __construct(MovieRepository $movieRepository, MovieAssembler $movieAssembler)
    {
        $this->movieRepository = $movieRepository;
        $this->movieAssembler = $movieAssembler;
    }
    
    /**
     * Lists all Movies
     * @Rest\Get("/movie")
     *
     * @return Response
     */
    public function getMovieAction() {
        $allMovies = $this->movieRepository->findAll();

        $movieOutputDTOs = [];
        foreach($allMovies as $movieEntity){
            $movieOutputDTOs[] = $this->movieAssembler->createMovieOutputDTO($movieEntity);
        }
        return $this->handleView($this->view($movieOutputDTOs));
    }

    /**
     * Creates an Movie resource
     *
     * @Rest\Post("/movies")
     *
     * @SWG\Post(
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *       name="body",
     *       in="body",
     *       description="json order object",
     *       required=true,
     *     format="application/json",
     *       @SWG\Schema(
     *             required={"title", "genre"},
     *             @SWG\Property(property="title", type="string"),
     *             @SWG\Property(property="genre", type="integer"),
     *             @SWG\Property(property="released", type="yyy-mm-dd"),
     *             @SWG\Property(property="price_type", type="string (default, length, kids)"),
     *             example={"title": "string", "genre": 1, "released": "2020-12-20","price_type": "length"}
     *         )
     *      )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Returns a MovieOutputDTO",
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postMovie(Request $request): View
    {
        $movieDTO =  new MovieInputDTO(
            $request->get('title'),
            $request->get('genre'),
            $request->get('released'),
            $request->get('price_type', 'default')
        );

        $movieEntity = $this->movieAssembler->createMovie($movieDTO);
        $this->movieRepository->save($movieEntity);


        $movieOutputDTO = $this->movieAssembler->createMovieOutputDTO($movieEntity);
        // In case our POST was a success we need to return a 201 HTTP CREATED response with the created object
        return View::create($movieOutputDTO, Response::HTTP_CREATED);
    }

}