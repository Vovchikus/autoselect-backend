<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
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
   * @ORM\Column(type="string", length=5)
   */
  protected $key;

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

  /**
   * @return mixed
   */
  public function getKey()
  {
    return $this->key;
  }

  /**
   * @param mixed $key
   * @return $this
   */
  public function setKey($key)
  {
    $this->key = $key;
    return $this;
  }


}