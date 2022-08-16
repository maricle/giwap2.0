<?php

namespace App\Repository;

use App\Entity\Estadotrabajo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Estadotrabajo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estadotrabajo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estadotrabajo[]    findAll()
 * @method Estadotrabajo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadotrabajoRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Estadotrabajo::class);
    }

    /**
     * @return Estadotrabajo[] Returns an array of Estadotrabajo objects
     */
//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /**
     * @return Estadotrabajo  Returns the next estado 
     */
    public function findNextEstado($value): ?Estadotrabajo {
   //devuelvo el proximo estado o el primero si no encuentra otro
 
        
       // dump($value->getId()); die;
        if (!is_null($value) and ($value->getId() > 6)) {
            return null;
        } 
        else {
         
            return $this->createQueryBuilder('e')
                ->andWhere('e.id = :val')
                ->setParameter('val', ( is_null($value)? 1 : $value->getId()) + 1)
                ->getQuery()
                ->getOneOrNullResult();
        }

    }
     /**
     * @return Estadotrabajo  Returns the previus estado 
     */
    public function findPrevEstado($value): ?Estadotrabajo {
   //devuelvo el proximo estado o el primero si no encuentra otro
 
        
       // dump($value->getId()); die;
        if (!is_null($value) and ($value->getId() == 1) ) {
            return null;
        } 
        else {
        
            return $this->createQueryBuilder('e')
                ->andWhere('e.id = :val')
                ->setParameter('val', ( is_null($value)? 2 : $value->getId()) - 1)
                ->getQuery()
                ->getOneOrNullResult();
        }

    }
}
