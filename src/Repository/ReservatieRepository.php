<?php

namespace App\Repository;

use App\Entity\Reservatie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reservatie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservatie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservatie[]    findAll()
 * @method Reservatie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservatieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservatie::class);
    }

    /**
     * @return Reservering[] Returns an array of Reservering objects
     * dag is input variabele van ingevoerde dag
     */
    public function findreserveringendag($dag)
    {
        //zet de range voor de betreffende dag  voor uren , minuten en seconden anders lukte het niet
        $from = new \DateTime($dag->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($dag->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder('r')
            ->andWhere('r.datum_tijd BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->orderBy('r.datum_tijd', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }


    /**
     * @return Reservering[] Returns an array of Reservering objects
     * dag is input variabele van ingevoerde dag
     */
    /* public function findreserveringendag($dag)
     {
         //zet de range voor de betreffende dag  voor uren , minuten en seconden anders lukte het niet
         $from = new \DateTime($dag->format("Y-m-d")." 00:00:00");
         $to   = new \DateTime($dag->format("Y-m-d")." 23:59:59");

         $qb = $this->createQueryBuilder('r')
             ->select('r', 't')
             ->andWhere('r.datum_tijd BETWEEN :from AND :to')
             ->innerJoin('r.reservatieid', 't', 'WITH', 't.reservatie_id = :id')
             ->setParameter('from', $from )
             ->setParameter('to', $to)
             // waarde 1 is niet juist hij vind dan alles
             ->setParameter('id', 1)
             ->orderBy('r.datum_tijd', 'ASC')
         ;

         return $qb->getQuery()->getResult();
     }*/

    // /**
    //  * @return Reservatie[] Returns an array of Reservatie objects
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
    public function findOneBySomeField($value): ?Reservatie
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
