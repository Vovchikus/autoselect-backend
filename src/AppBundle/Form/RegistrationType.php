<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


/**
 * Class RegistrationType
 * @package AppBundle\Form
 */
class RegistrationType extends AbstractType
{
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('email', EmailType::class)
      ->add('username', TextType::class, ['attr' => ['minlength' => 4, 'maxLength' => 25]])
      ->add('plainPassword', RepeatedType::class, [
          'type' => PasswordType::class,
          'first_options'  => ['label' => 'Password'],
          'second_options' => ['label' => 'Repeat Password'],
        ]
      )->add('remember', 'checkbox', ['mapped' => false, 'required' => false]);
  }

  /**
   * @return string
   */
  public function getParent()
  {
    return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  }

  /**
   * @return string
   */
  public function getBlockPrefix()
  {
    return 'app_user_registration';
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->getBlockPrefix();
  }
}