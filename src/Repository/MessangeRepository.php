<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Message::class);
    }

    public function findByUser($user)
    {   
        $result = $this->repository->createQueryBuilder('m')
             ->where(':user MEMBER OF m.iduser')
             ->setParameter("user", $user->getID())
             ->orderBy('m.date', 'DESC')
             ->getQuery()
            ->getResult();

        return $result;
    }
    

}
