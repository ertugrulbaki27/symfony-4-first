<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findAllBelowPrice(float $price)
    {
        // alias for the table that we're talking about.
//        return $this->createQueryBuilder('h')
//                    ->andWhere('h.price < :price')
//                    ->setParameter('price', $price)
//                    ->orderBy('h.id', 'ASC')
//                    ->setMaxResults(10)
//                    ->getQuery() //  turn it into a query.
//                    ->getResult(); // which will run the query and hydrate those entities,
        // return us an array with those entities in.

        // this is rwa sql shape
        $entityManager = $this->getEntityManager();
        // The entity manager is a central access point to all of the entities from within our application.
        return $entityManager->createQuery(
            'SELECT h FROM App\Entity\Hotel h
                WHERE h.price < :price
                ORDER BY h.id ASC
            '
        )->setParameter('price', $price)
         ->execute();
    }

    // /**
    //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotel
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
