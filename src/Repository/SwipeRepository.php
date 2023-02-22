<?php

namespace App\Repository;

use App\Entity\Swipe;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Swipe>
 *
 * @method Swipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Swipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Swipe[]    findAll()
 * @method Swipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SwipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Swipe::class);
    }

    public function save(Swipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Swipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getExistingSwipe(User $swipper, User $swipped)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
            ->from(Swipe::class, 's')
            ->where(
                $qb->expr()->eq('s.swipper', ':swipperId'),
                $qb->expr()->eq('s.swipped', ':swippedId')
            )
            ->setParameter('swipperId', $swipper->getId())
            ->setParameter('swippedId', $swipped->getId())
            ->setMaxResults(1);
        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult();

        return $result;
    }

//    /**
//     * @return Swipe[] Returns an array of Swipe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Swipe
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
