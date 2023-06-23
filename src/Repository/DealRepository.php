<?php

namespace App\Repository;

use App\Entity\Deal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deal::class);
    }

    public function save(Deal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Deal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    public function getHotDealsTries()
    {
        $query = $this->createQueryBuilder('deal');
        $query->where("deal.degreAttractivite >= 100")
            ->orderBy("deal.datePublication","ASC");
        return $query->getQuery()->getResult();
    }

    public function getNewDealsTries()
    {
        $query = $this->createQueryBuilder('deal');
        $query->orderBy("deal.datePublication","ASC");
        return $query->getQuery()->getResult();
    }

    public function findByTitleOrDescription($term)
    {
        $query = $this->createQueryBuilder('d')
            ->where('d.titre LIKE :term OR d.description LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery();

        return $query->getResult();
    }

    /* public function getDealsCommentesTries()
    {
        $query = $this->createQueryBuilder('deal');
        $query->join("deal.userDealInteraction",'i')
            ->where("i.commentaire > 1")
            ->orderBy("deal.datePublication","ASC")
            ->setParameter("countDeals", $this->countDealsCommentes());
        return $query->getQuery()->getResult();
    }

    private function countDealsCommentes()
    {
        $query = $this->createQueryBuilder('userDealInteraction');
        $query->select("COUNT(userDealInteraction.commentaires)");
        return $query->getQuery()->getResult();
    } */
}
