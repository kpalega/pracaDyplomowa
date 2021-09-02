<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository
{
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Invoice::class);
    }
    
    // /**
    //  * @return Invoice[] Returns an array of Invoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invoice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /*
    *   @return Invoice[]
    */

    public function findByDate($date, $limit, $offset)
    {
        
         $result = $this->repository->createQueryBuilder('i')
            ->andWhere('i.date < :val')
            ->setParameter('val', $date)
            ->orderBy('i.date', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function count()
    {
        
         $result = $this->repository->createQueryBuilder('i')
            ->select('COUNT (i.invoicenumber)')
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return $result;
    }
}
