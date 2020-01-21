<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;



/**
 * Genre service controller.
 * @Route("/api", name="api_")
 */
class GenreServiceController extends AbstractFOSRestController {

    /**
     * Lists all Genres
     * @Rest\Get("/genre")
     *
     * @return Response
     */
    public function getGenreAction() {
        $repository = $this->getDoctrine()->getRepository(Genre::class);
        $allGenres = $repository->findAll();
        return $this->handleView($this->view($allGenres));
    }

    /**
     * Create Genre. Using a GenreType class to validate input
     *
     * @Rest\Post("/genre")
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
     *             required={"name"},
     *             @SWG\Property(property="name", type="string"),
     *             example={"name": "string"}
     *         )
     *      )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Returns a Genre entity",
     *     )
     * )
     *
     * @return Response
     */
    public function postGenreAction(Request $request) {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $data = json_decode($request->getContent(), TRUE);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();
            return $this->handleView($this->view($genre, Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}