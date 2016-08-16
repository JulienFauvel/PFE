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
}
