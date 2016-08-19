<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{

    /**
     * Returns all the Categories
     *
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->createQueryBuilder('cat')
            ->getQuery()
            ->getArrayResult();
    }

}