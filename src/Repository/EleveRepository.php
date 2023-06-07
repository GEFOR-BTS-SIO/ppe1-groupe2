<?php

namespace App\Repository;

use App\Entity\Eleve;
use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Eleve>
 *
 * @method Eleve|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eleve|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eleve[]    findAll()
 * @method Eleve[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EleveRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eleve::class);
    }

    public function save(Eleve $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Eleve $entity, bool $flush = false): void
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
        if (!$user instanceof Eleve) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

   /**
   */
    public function search($searchTerm)
    {
        $qb = $this->createQueryBuilder('b')
        ->where('b.name LIKE :searchTerm')
        ->orWhere('b.firstname LIKE :searchTerm')
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->getQuery();

    return $qb->execute();
            
    }

    public function findByRole(string $role, string $name = null, Formation $formation = null)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        if(!empty($name)){
            $queryBuilder->where('u.name LIKE :name')
                ->orWhere('u.firstname LIKE :name')
                ->setParameter('name', '%'.$name.'%');
        }
        if(!empty($formation)){
            $queryBuilder->andWhere('u.idCursus = :formation')
                ->setParameter('formation', $formation->getId());
        }
        
        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Eleve
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
