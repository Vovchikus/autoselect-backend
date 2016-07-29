<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{

  const ROLE_CUSTOMER = 'ROLE_CUSTOMER';

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * User constructor.
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @return array
   */
  public function getContent()
  {
    return [
      'username' => $this->getUsername()
    ];
  }

}