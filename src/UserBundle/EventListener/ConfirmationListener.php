<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use UserBundle\Entity\User;

/**
 * Class ConfirmationListener
 * @package UserBundle\EventListener
 */
class ConfirmationListener implements EventSubscriberInterface
{

  /**
   * @var UrlGeneratorInterface
   */
  private $router;

  /**
   * ConfirmationListener constructor.
   * @param UrlGeneratorInterface $router
   */
  public function __construct(UrlGeneratorInterface $router)
  {
    $this->router = $router;
  }

  /**
   * @inheritdoc
   */
  public static function getSubscribedEvents()
  {
    return [
      FOSUserEvents::REGISTRATION_CONFIRM => 'onRegistrationConfirm'
    ];
  }

  /**
   * @param GetResponseUserEvent $event
   */
  public function onRegistrationConfirm(GetResponseUserEvent $event)
  {
    $user = $event->getUser();
    if (in_array(User::ROLE_CUSTOMER, $user->getRoles())) {
      $url = $this->router->generate('customer_index');
    } else {
      $url = $this->router->generate('/');
    }
    $event->setResponse(new RedirectResponse($url));
  }
}