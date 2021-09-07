<?php

namespace App\Repository;

use App\Entity\Child;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Child|null find($id, $lockMode = null, $lockVersion = null)
 * @method Child|null findOneBy(array $criteria, array $orderBy = null)
 * @method Child[]    findAll()
 * @method Child[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChildRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Child::class);
    }
    
    // /**
    //  * @return Child[] Returns an array of Child objects
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
    public function findOneBySomeField($value): ?Child
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
    *   @return Child[]
    */

    public function findByLimit($limit, $offset)
    {   
         $result = $this->repository->createQueryBuilder('c')
            ->orderBy('c.surname', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }
    

    public function countPages($LIMIT) : int
    {
        
        $result = $this->repository->createQueryBuilder('c')
            ->select('COUNT (c.idchild)')
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return ceil($result/$LIMIT);
    }

    
    public function findDisabilities($id){
        
        $result = $this->repository->createQueryBuilder('c')
        ->join('c.iddisability', 'd')
        ->where('d.iddisability = :id')
        ->setParameter("id", $id)
        ->getQuery()
        ->getResult();
        
        return $result;
    }
}
