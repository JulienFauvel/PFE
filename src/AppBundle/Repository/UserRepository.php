<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUsers()
    {
        return $this->createQueryBuilder('user')
            ->getQuery()
            ->getArrayResult();
    }
    
    
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('user')
            ->where('user.username = :username')
            ->setParameter(':username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByMail($mail)
    {
        return $this->createQueryBuilder('user')
            ->where('user.mail = :mail')
            ->setParameter(':mail', $mail)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
