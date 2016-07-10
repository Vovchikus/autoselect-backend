<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use UserBundle\Entity\User;

/**
 * Class RegistrationListener
 */
class RegistrationListener implements EventSubscriberInterface
{

  /**
   * @var UrlGeneratorInterface
   */
  private $router;

  /**
   * @var ContainerInterface
   */
  private $container;

  /**
   * @var TokenGeneratorInterface
   */
  private $tokenGenerator;

  /**
   * @var MailerInterface
   */
  private $mailer;


  /**
   * RegistrationListener constructor.
   * @param UrlGeneratorInterface $router
   * @param ContainerInterface $container
   * @param TokenGeneratorInterface $tokenGenerator
   * @param MailerInterface $mailer
   */
  public function __construct(
    UrlGeneratorInterface $router,
    ContainerInterface $container,
    TokenGeneratorInterface $tokenGenerator,
    MailerInterface $mailer
  )
  {
    $this->router = $router;
    $this->container = $container;
    $this->tokenGenerator = $tokenGenerator;
    $this->mailer = $mailer;
  }

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents()
  {
    return [
      FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
    ];
  }

  /**
   * @param FormEvent $event
   */
  public function onRegistrationSuccess(FormEvent $event)
  {
    /** @var User $user */
    $user = $event->getForm()->getData();
    $user->setEnabled(false);
    $user->setConfirmationToken($this->tokenGenerator->generateToken());
    $user->setRoles([User::ROLE_DEFAULT, User::ROLE_CUSTOMER]);
  }

}