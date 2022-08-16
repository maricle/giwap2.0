<?php

namespace App\Repository;

use App\Entity\OrdenCaracteristica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrdenCaracteristica|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrdenCaracteristica|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrdenCaracteristica[]    findAll()
 * @method OrdenCaracteristica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdenCaracteristicaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdenCaracteristica::class);
    }

    // /**
    //  * @return OrdenCaracteristica[] Returns an array of OrdenCaracteristica objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrdenCaracteristica
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
