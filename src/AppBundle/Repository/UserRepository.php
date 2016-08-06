<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * UserRepository
 *
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{

    /**
     * Returns all the users
     *
     * @return User[]
     */
    public function loadUsers()
    {
        return $this->createQueryBuilder('user')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Return the user with the username
     *
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('user')
            ->where('user.username = :username')
            ->setParameter(':username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Return the user with the mail
     *
     * @param string $mail
     * @return User
     */
    public function loadUserByMail($mail)
    {
        return $this->createQueryBuilder('user')
            ->where('user.mail = :mail')
            ->setParameter(':mail', $mail)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
