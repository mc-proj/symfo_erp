<?php

namespace App\Repository;

use App\Entity\SerpIntervenant;
use App\Entity\SerpTypeIntervenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpTypeIntervenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpTypeIntervenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpTypeIntervenant[]    findAll()
 * @method SerpTypeIntervenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpTypeIntervenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpTypeIntervenant::class);
    }

    // /**
    //  * @return SerpTypeIntervenant[] Returns an array of SerpTypeIntervenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SerpTypeIntervenant
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
