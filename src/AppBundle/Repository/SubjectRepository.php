<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 */
class SubjectRepository extends EntityRepository
{
    public function getSubjects()
    {
        return $this->createQueryBuilder('subject')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Get the subject by user
     * @param integer $id ID of the user
     * @return array
     */
    public function getSubjectsByUser(int $id)
    {
        return $this->createQueryBuilder('s')
            ->where('s.user = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
