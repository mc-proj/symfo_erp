<?php

namespace App\Repository;

use App\Entity\SerpCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SerpCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method SerpCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method SerpCategories[]    findAll()
 * @method SerpCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerpCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SerpCategories::class);
    }

    public function findAllSortedByNomAsc() {

        return $this->findBy(array(), array('nom' => 'ASC'));
    }

    // /**
    //  * @return SerpCategories[] Returns an array of SerpCategories objects
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
    public function findOneBySomeField($value): ?SerpCategories
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
