<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Group::class);
    }
    
    // /**
    //  * @return Group[] Returns an array of Group objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Group
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /*
    *   @return Group[]
    */

    public function findByLimit($limit, $offset)
    {   
         $result = $this->repository->createQueryBuilder('g')
            ->orderBy('g.name', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }
    

    public function countPages($LIMIT) : int
    {
        
        $result = $this->repository->createQueryBuilder('g')
            ->select('COUNT (g.idclass)')
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return ceil($result/$LIMIT);
    }

}
