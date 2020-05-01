<?php

namespace App\Repository;

use App\Entity\Toppings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Toppings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Toppings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Toppings[]    findAll()
 * @method Toppings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToppingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Toppings::class);
    }

    // /**
    //  * @return Toppings[] Returns an array of Toppings objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Toppings
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
