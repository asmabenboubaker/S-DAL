<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Cat;
use App\Entity\Marque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Marque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marque[]    findAll()
 * @method Marque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marque::class);
       
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Marque $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Marque $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Marque[] Returns an array of Marque objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marque
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Marque[]
     */
    public function findSearch(SearchData $search):array
    {
       $query=$this
       ->createQueryBuilder('m')
       ->select('c','m')
       
       ->join('m.cat','c');


       if(!empty($search->q)){
        $query=$query
        ->andWhere('m.nom LIKE :q')
        ->setParameter('q',"%{$search->q}%");
       }

       if(!empty($search->categories)){
        $query=$query
        ->andWhere('c.id IN (:categories)')
        ->setParameter('categories',$search->categories);
       }


          return $query->getQuery()->getResult();
    }
  
}
