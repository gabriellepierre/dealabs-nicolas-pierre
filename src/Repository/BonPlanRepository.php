<?php

namespace App\Repository;

use App\Entity\BonPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BonPlan>
 *
 * @method BonPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonPlan[]    findAll()
 * @method BonPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonPlan::class);
    }

    public function save(BonPlan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BonPlan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getHotBonsPlanTries()
    {
        $query = $this->createQueryBuilder('bon_plan');
        $query->where("bon_plan.degreAttractivite >= 100")
            ->orderBy("bon_plan.datePublication","ASC");
        return $query->getQuery()->getResult();
    }
}
