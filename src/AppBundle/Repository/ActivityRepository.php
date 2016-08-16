<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Activity;
use Doctrine\ORM\EntityRepository;

/**
 * ActivityRepository
 *
 */
class ActivityRepository extends EntityRepository
{

    /**
     * Simple search query
     *
     * @param $q
     * @return Activity[]
     */
    public function searchInTitle($q)
    {
        return $this->createQueryBuilder('a')
            ->where('lower(a.title) LIKE lower(:title)')
            ->setParameter('title', '%'.$q.'%')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActivities($limit = 20, $offset = 0)
    {
        return $this->createQueryBuilder('a')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

}
