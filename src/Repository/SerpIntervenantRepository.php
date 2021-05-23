<?php

namespace App\Repository;

use App\Entity\SerpIntervenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpIntervenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpIntervenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpIntervenant[]    findAll()
 * @method SerpIntervenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpIntervenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpIntervenant::class);
    }

    public function getAllSortedByNom() {

        return $this->createQueryBuilder('i')
            ->orderBy('i.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpIntervenant[] Returns an array of SerpIntervenant objects
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
    public function findOneBySomeField($value): ?SerpIntervenant
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
