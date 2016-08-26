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
            ->getResult();
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

    /**
     * Get the Activity with the ID
     *
     * @param int $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActivity($id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the activities by category name
     *
     * @param string $name
     * @return array
     */
    public function getActivitiesByCategory($name)
    {
        return $this->createQueryBuilder('a')
            ->join('a.category', 'c')
            ->where('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get the activities by User
     * @param integer $id ID of the user
     * @return array
     */
    public function getActivitiesByUser(int $id)
    {
        return $this->createQueryBuilder('a')
            ->where('a.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }



}
