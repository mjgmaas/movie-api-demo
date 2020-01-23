<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @param Movie $movie
     */
    public function save(Movie $movie): void
    {
        $this->getEntityManager()->persist($movie);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Movie $movie
     */
    public function delete(Movie $movie): void
    {
        $this->getEntityManager()->remove($movie);
        $this->getEntityManager()->flush();
    }

}
