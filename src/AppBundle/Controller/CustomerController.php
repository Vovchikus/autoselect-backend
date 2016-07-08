<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class CustomerController
 * @package AppBundle\Controller
 */
class CustomerController extends Controller
{

  /**
   * @Security("has_role('ROLE_CUSTOMER')")
   * @Route("/customer/index", name="customer_index")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function indexAction(Request $request)
  {
    return $this->render('AppBundle:Customer:index.html.twig');
  }

}