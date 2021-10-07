<?php

namespace App\Repository;

use App\Entity\ChatEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChatEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatEntity[]    findAll()
 * @method ChatEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatEntity::class);
    }

    // /**
    //  * @return ChatEntity[] Returns an array of ChatEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChatEntity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
