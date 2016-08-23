<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function getUsers()
    {
        return $this->createQueryBuilder('user')
            ->getQuery()
            ->getResult();
    }

    /**
     * Return a user by his ID
     *
     * @param integer $id
     * @return User
     */
    public function getUser($id)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Return the user with the username
     *
     * @param string $username
     * @return User
     */
    public function getUserByUsername($username)
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
     * @param string $email
     * @return User
     */
    public function getUserByEmail($email)
    {
        return $this->createQueryBuilder('user')
            ->where('user.email = :email')
            ->setParameter(':email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     *
     * @return UserInterface|null
     */
    public function loadUserByUsername($username)
    {
        return $this->getUserByUsername($username);
    }
}
