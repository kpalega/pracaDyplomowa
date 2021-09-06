<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

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

    public function findByDate($dateEnd, $dateStart, $limit, $offset)
    {
        
         $result = $this->repository->createQueryBuilder('i')
            ->andWhere(' i.date >= :valStart AND i.date <= :valEnd')
            ->setParameter('valEnd', $dateEnd)
            ->setParameter('valStart', $dateStart)
            ->orderBy('i.date', 'DESC')
            ->setFirstResult( $offset )
            ->setMaxResults( $limit )
            ->getQuery()
            ->getResult()
        ;
        return $result;
    }

    public function countPages($dateEnd, $dateStart, $LIMIT) : int
    {
        
         $result = $this->repository->createQueryBuilder('i')
            ->select('COUNT (i.invoicenumber)')
            ->where('i.date > :valStart AND i.date < :valEnd')
            ->setParameter('valEnd', $dateEnd)
            ->setParameter('valStart', $dateStart)
            ->getQuery()
            ->getSingleScalarResult();
        ;
        return $result/$LIMIT;
    }

    public function getInvoicesByCategory($category, $dateEnd, $dateStart){

        return $this->repository->createQueryBuilder('i')
        ->where('i.date > :valStart AND i.date <= :valEnd AND i.idcategory = :cat')
        ->setParameter('valEnd', $dateEnd)
        ->setParameter('valStart', $dateStart)
        ->setParameter('cat', $category)
        ->getQuery()
        ->getResult();
    }

}
