<?php

namespace App\Repository;

use App\Entity\SerpMatiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpMatiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpMatiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpMatiere[]    findAll()
 * @method SerpMatiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpMatiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpMatiere::class);
    }

    public function getAllSortedByNom() {

        return $this->createQueryBuilder('m')
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpMatiere[] Returns an array of SerpMatiere objects
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
    public function findOneBySomeField($value): ?SerpMatiere
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
