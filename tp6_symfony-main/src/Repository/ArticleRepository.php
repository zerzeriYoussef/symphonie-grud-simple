<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Find articles with price between min and max values
     * 
     * @param float $minPrice Minimum price
     * @param float $maxPrice Maximum price
     * @return Article[] Returns an array of Article objects
     */
    public function findByPriceRange(float $minPrice, float $maxPrice): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.prix >= :minPrice')
            ->andWhere('a.prix <= :maxPrice')
            ->setParameter('minPrice', $minPrice)
            ->setParameter('maxPrice', $maxPrice)
            ->orderBy('a.prix', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
