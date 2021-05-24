<?php

namespace App\Repository;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->managerRegistry = $registry;
    }

    public function findById(string $id)
    {
        return $this->managerRegistry->getRepository(User::class)
                              ->find($id);
    }

    public function findAll()
    {
        return $this->managerRegistry->getRepository(User::class)
                                    ->findAll();
    }

    public function save(User $user): User
    {
        $manager = $this->managerRegistry->getManager();
        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    public function delete(User $user): User
    {
        $manager = $this->managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        return $user;
    }

    public function update(User $user)
    {
        $manager = $this->managerRegistry->getManager();
        $manager->flush();
    }

    // public function findAllOrderedByName()
    // {
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
    //         )
    //         ->getResult();
    // }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
