<?php

namespace App\Repository;

use App\Entity\VerificationRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VerificationRequest>
 *
 * @method VerificationRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method VerificationRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method VerificationRequest[]    findAll()
 * @method VerificationRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerificationRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerificationRequest::class);
    }

    public function save(VerificationRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VerificationRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VerificationRequest[] Returns an array of VerificationRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VerificationRequest
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
