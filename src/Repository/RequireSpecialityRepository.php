<?php

namespace App\Repository;

use App\Entity\RequireSpeciality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RequireSpeciality|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequireSpeciality|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequireSpeciality[]    findAll()
 * @method RequireSpeciality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequireSpecialityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequireSpeciality::class);
    }

    // /**
    //  * @return RequireSpeciality[] Returns an array of RequireSpeciality objects
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
    public function findOneBySomeField($value): ?RequireSpeciality
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
