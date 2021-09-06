<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(News::class);
    }
    
    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /*
    *   @return News[]
    */

    public function findByLimit($limit, $offset)
    {
        
         $result = $this->repository->createQueryBuilder('n')
            ->orderBy('n.date', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function countPages($LIMIT) : int
    {
        
        $result = $this->repository->createQueryBuilder('n')
            ->select('COUNT (n.idnews)')
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return ceil($result/$LIMIT);
    }
}
