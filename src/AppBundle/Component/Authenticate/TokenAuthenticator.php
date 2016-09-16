<?php

namespace AppBundle\Component\Authenticate;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use UserBundle\Entity\User;

/**
 * Class TokenAuthenticator
 * @package AppBundle\Authenticate\Response
 */
class TokenAuthenticator extends AbstractGuardAuthenticator
{

  private $em;

  /**
   * TokenAuthenticator constructor.
   * @param EntityManager $em
   */
  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  /**
   * @param Request $request
   * @param AuthenticationException|null $authException
   * @return JsonResponse
   */
  public function start(Request $request, AuthenticationException $authException = null)
  {
    $data = [
      'message' => 'Authentication Required'
    ];

    return new JsonResponse($data, 401);
  }

  /**
   * @param Request $request
   * @return array|null
   */
  public function getCredentials(Request $request)
  {
    if (!$token = $request->headers->get('X-AUTH-TOKEN')) {
      return null;
    }
    return [
      'token' => $token,
    ];
  }

  /**
   * @param mixed $credentials
   * @param UserProviderInterface $userProvider
   * @return null|User
   */
  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    $apiKey = $credentials['token'];

    return $this->em->getRepository('UserBundle:User')
      ->findOneBy(['key' => $apiKey]);
  }

  /**
   * @param mixed $credentials
   * @param \Symfony\Component\Security\Core\User\UserInterface $user
   * @return bool
   */
  public function checkCredentials($credentials, \Symfony\Component\Security\Core\User\UserInterface $user)
  {
    return true;
  }

  /**
   * @param Request $request
   * @param AuthenticationException $exception
   * @return JsonResponse
   */
  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    $data = [
      'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
    ];
    return new JsonResponse($data, 403);
  }

  /**
   * @param Request $request
   * @param TokenInterface $token
   * @param string $providerKey
   * @return null
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {
    return null;
  }

  /**
   * @return bool
   */
  public function supportsRememberMe()
  {
    return false;
  }
}