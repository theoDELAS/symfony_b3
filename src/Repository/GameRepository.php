<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getLatestPaginatedGames(PaginatorInterface $paginator, $page = 1) 
    {
        $query = $this->createQueryBuilder('g')
            ->orderBy('g.date_add', 'DESC')
            ->getQuery();

        return $paginator->paginate($query, $page, 9);
    }
    
    public function getLatestPaginatedGamesByCategory(PaginatorInterface $paginator, $categoryId = 1, $page = 1) {
        $query = $this->createQueryBuilder('g')
            ->andWhere('g.category = ' . $categoryId)
            ->orderBy('g.date_add', 'DESC')
            ->getQuery();
        
        return $paginator->paginate($query, $page, 9);
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
