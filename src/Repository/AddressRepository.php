<?php

namespace App\Repository;

use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function findByPosition($lat, $lon, $radius)
    {
        $qb = $this->createQueryBuilder('a');
        $haversineFormula = "( 6371 * acos( cos( radians($lat) ) * cos( radians( a.lat ) ) 
        * cos( radians( a.lon ) - radians($lon) ) + sin( radians($lat) ) * sin(radians(a.lat)) ) ) <= :radius"; 
        $qb->andWhere($haversineFormula);
        $qb->setParameter('radius', $radius);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
