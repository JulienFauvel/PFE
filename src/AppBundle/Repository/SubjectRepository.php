<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * SubjectRepository
 *
 */
class SubjectRepository extends EntityRepository
{
    /**
     * Get all subjects
     *
     * @return array
     */
    public function getSubjects()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->addOrderBy('s.editedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     *
     */
    public function getSubject($id)
    {
        return $this->createQueryBuilder('subject')
            ->where('subject.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
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
