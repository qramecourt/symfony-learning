<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use DateInterval;
/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findByKeyboard($keyword): array
    {
        return $this->createQueryBuilder('a')
            ->andwhere('a.title LIKE :keyword')
            ->orwhere('a.body LIKE :')
            ->setParameter('keyword', "%{$keyword}%")
            ->orderBy('a.id', 'ASC')
            ->orderBy('a.published_at', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            

            ;
    }

   /**
    * @return Article[] Returns an array of Article objects
    */
   public function findAllSorted(): array
   {
       return $this->createQueryBuilder('a')//c'est comme l'alias du nom de table en SQL
           ->orderBy('a.title', 'ASC')//c'est ici qu'on trie: a.title c'est par titre d'article
           ->setMaxResults(10)
           ->getQuery()//génère un objet Query (type requet SQL) c'est ici qu'on fait la requete
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByRole(){
    //a remplir
}



public function finByPublishedAtBefore() {
$interval = DateInterval::createGromDateString('1 day');
return $this->createQueryBuilder('a')
            ->andWhere('a.published_at <= :date')
            ->setParameter('date', $date->format('Y-m-d 00:00:00'))
            ->orderBy('a.published_at','DESC')
            ->addOrderBy('a.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
public function findNlast($n): array 
{
    return $this->createQueryBuilder('a')
        ->orderBy('a.pulbished_at', 'DESC')
        ->setMaxResults($n)
        ->getQuery()
        ->setResult();
}

}
