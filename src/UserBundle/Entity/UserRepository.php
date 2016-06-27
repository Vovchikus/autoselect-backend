<?php

namespace UserBundle\Entity;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserRepository
 * @package UserBundle\Entity
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{

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
    return $this->createQueryBuilder('u')
      ->where('u.username = :username OR u.email = :email')
      ->setParameter('username', $username)
      ->setParameter('email', $username)
      ->getQuery()
      ->getOneOrNullResult();
  }
}