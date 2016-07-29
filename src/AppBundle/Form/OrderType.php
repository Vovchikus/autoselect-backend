<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class OrderType
 */
class OrderType extends AbstractType
{

  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('id')
      ->add('title')
      ->add('save', 'submit');
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'order';
  }

}