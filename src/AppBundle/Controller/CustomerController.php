<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CustomerController
 * @package AppBundle\Controller
 */
class CustomerController extends Controller
{

  /**
   * @Route("/customer/main", name="customer_main")
   */
  public function mainAction()
  {
    print_r('page for customers');
  }

}