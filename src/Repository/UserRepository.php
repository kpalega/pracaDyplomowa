<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function findByLimit($limit, $offset)
    {   
         $result = $this->repository->createQueryBuilder('u')
            ->where('u.idspecialization > 0')
            ->orderBy('u.surname', 'ASC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }
    

    public function countPages($LIMIT) : int
    {
        
        $result = $this->repository->createQueryBuilder('u')
            ->where('u.idspecialization > 0')
            ->select('COUNT (u.IDuser)')
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return ceil($result/$LIMIT);
    }

}
