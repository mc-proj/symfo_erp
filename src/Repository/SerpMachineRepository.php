<?php

namespace App\Repository;

use App\Entity\SerpMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpMachine|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpMachine|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpMachine[]    findAll()
 * @method SerpMachine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpMachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpMachine::class);
    }

    public function getAllSortedByNom() {

        return $this->createQueryBuilder('m')
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return SerpMachine[] Returns an array of SerpMachine objects
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
    public function findOneBySomeField($value): ?SerpMachine
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
