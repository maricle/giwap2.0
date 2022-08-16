<?php

namespace App\Repository;

use App\Entity\Puntodeventa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Puntodeventa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Puntodeventa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Puntodeventa[]    findAll()
 * @method Puntodeventa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PuntodeventaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Puntodeventa::class);
    }

    // /**
    //  * @return Puntodeventa[] Returns an array of Puntodeventa objects
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
    public function findOneBySomeField($value): ?Puntodeventa
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
