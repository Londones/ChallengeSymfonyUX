<?php

namespace App\Repository;

use App\Entity\Channel;
use App\Entity\Swipe;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function getChannels(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from(Channel::class, 'c')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('c.firstUser', ':userId'),
                $qb->expr()->eq('c.secondUser', ':userId')
            ))
            ->setParameter('userId', $user->getId());
        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function getUserToSwipe(User $user) 
    {
        $categories = $user->getCategory()->toArray();
        $categoriesId = array_values(array_map(function($category) {
            return $category->getId();
        }, $categories));

        $swipes = $user->getSwipes()->toArray();
        $swippedId = array_values(array_map(function($swipe) {
            return $swipe->getSwipped()->getId();
        }, $swipes));

        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('u')
            ->from(User::class, 'u')
            ->join('u.category', 'c')
            ->where('c.id IN (:categoriesId)')
            ->andWhere('u.id != :userId')
            ->setParameter('categoriesId', $categoriesId)
            ->setParameter('userId', $user->getId())
            ->orderBy('u.createdAt', 'ASC')
            ->setMaxResults(1);
        if($swippedId){
            $qb->andWhere('u.id NOT IN (:swippedId)')
                ->setParameter('swippedId', $swippedId);
        }

        $query = $qb->getQuery();
        $result = $query->getOneOrNullResult();

        return $result;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
