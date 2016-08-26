<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{

    /**
     * Get all contacts
     */
    public function getContacts()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult();
    }

}