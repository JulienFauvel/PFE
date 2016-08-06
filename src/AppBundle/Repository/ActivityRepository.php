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
            ->where('a.name LIKE :name')
            ->setParameter('name', $q)
            ->getQuery()
            ->getArrayResult();
    }

}
