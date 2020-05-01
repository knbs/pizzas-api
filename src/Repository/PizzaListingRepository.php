<?php

namespace App\Repository;

use App\Entity\PizzaListing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaListing|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaListing|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaListing[]    findAll()
 * @method PizzaListing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaListingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaListing::class);
    }

    // /**
    //  * @return PizzaListing[] Returns an array of PizzaListing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PizzaListing
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
