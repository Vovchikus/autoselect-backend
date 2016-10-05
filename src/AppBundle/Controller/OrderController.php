<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 * @package AppBundle\Controller
 */
class OrderController extends Controller
{

  /**
   * @Route("/api/orders")
   * @Method("GET")
   * @param Request $request
   * @return Response
   */
  public function getOrdersAction(Request $request)
  {
    $orderRepository = $this->getDoctrine()
      ->getManager()
      ->getRepository(Order::class);
    /** @var Order[] $orders */
    $orders = $orderRepository->findAll();

    $result = [];

    foreach ($orders as $order) {
      $result[] = $order->getContent();
    }

    return new JsonResponse($result, Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*'], $request);
  }

  /**
   * @Route("/api/order")
   * @Method("POST")
   * @param Request $request
   * @return Response
   */
  public function postOrderAction(Request $request)
  {
    return new JsonResponse('hello', Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*'], $request);
  }

  /**
   * @Route("/api/order/{id}")
   * @Method("GET")
   * @param Request $request
   * @return Response
   */
  public function getOrderAction(Request $request)
  {
    $id = $request->get('id');
    $orderRepository = $this->getDoctrine()
      ->getManager()
      ->getRepository(Order::class);

    /** @var Order $order */
    $order = $orderRepository->find($id);
    $result = $order->getContent();

    return new JsonResponse($result, Response::HTTP_OK);

  }


}