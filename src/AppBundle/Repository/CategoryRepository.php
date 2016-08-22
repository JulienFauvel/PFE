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
            ->getResult();
    }

    /**
     * Return the category by its Display Name
     *
     * @param string $displayName
     * @return Category|null
     */
    public function getCategoryByDisplayName(string $displayName)
    {
        return $this->createQueryBuilder('cat')
            ->where('cat.display_name = :displayName')
            ->setParameter('displayName', $displayName)
            ->getQuery()
            ->getOneOrNullResult();
    }

}