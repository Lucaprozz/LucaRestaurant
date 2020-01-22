<?php

namespace App\Repository;

use App\Entity\ReservatieTafel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReservatieTafel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservatieTafel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservatieTafel[]    findAll()
 * @method ReservatieTafel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservatieTafelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservatieTafel::class);
    }

    public function findrestafelids($reserveringid)
    {
        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.reservatie_id = :rid')
            ->setParameter('rid', $reserveringid )
        ;
        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return ReservatieTafel[] Returns an array of ReservatieTafel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservatieTafel
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
