<?php

namespace App\Repository;

use App\Entity\Catastrophe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Catastrophe>
 *
 * @method Catastrophe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catastrophe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catastrophe[]    findAll()
 * @method Catastrophe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatastropheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catastrophe::class);
    }

    public function add(Catastrophe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Catastrophe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Catastrophe[] Returns an array of Catastrophe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Catastrophe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

      public function search($value)
    {
    return $this->createQueryBuilder('p')
        ->andWhere('p.nomCatastrophe  LIKE :searchItem OR p.description LIKE :searchItem')
        ->setParameter('searchItem', '%'.$value.'%')
        ->getQuery()
        ->getResult()
    ;
    }
       public function findByDate(): ?Array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Catastrophe c
            ORDER BY c.createdAt '
        );

        // returns an array of Product objects
        return $query->getResult();
       ;
   }

   public function findByPays(): ?Array
   {     
       return $this->createQueryBuilder('c')
       //->select('SUM(c.nombreMort)')
       //->leftJoin('c.pays', 'p')
       //->groupBy('p.nom')
       ->select('p.nom as pays','SUM(c.nombreMort) as nombreMort')
       ->leftJoin('c.pays','p')
       ->groupBy('p.nom')
       ->getQuery()
       ->getResult();
   }

   public function findByNombre(): ?Array{
    return $this->createQueryBuilder('c')
    ->select('p.nom as pays', 'COUNT(c) as count')
    ->leftJoin('c.pays','p')
    ->groupBy('p.nom')
    ->getQuery()
    ->getResult();

   }
   public function findByCategory(): ?Array{
    return $this->createQueryBuilder('c')
    ->select('s.nom as categorie', 'COUNT(c) as count')
    ->leftJoin('c.souscategorie','s')
    ->groupBy('s.nom')
    ->getQuery()
    ->getResult();

   }
   
}
