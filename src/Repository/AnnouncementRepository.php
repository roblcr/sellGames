<?php

namespace App\Repository;

use App\Entity\Announcement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Announcement>
 *
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }

    public function getRandomAnnouncements($limit = 3)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('RAND()')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findByPlaystation()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.platform = :platformName')
            ->setParameter('platformName', 'Playstation')
            ->getQuery()
            ->getResult();
    }

    public function findByXbox()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.platform = :platformName')
            ->setParameter('platformName', 'Xbox')
            ->getQuery()
            ->getResult();
    }

    public function findByPc()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.platform = :platformName')
            ->setParameter('platformName', 'PC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Announcement[] Returns an array of Announcement objects
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

    //    public function findOneBySomeField($value): ?Announcement
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
