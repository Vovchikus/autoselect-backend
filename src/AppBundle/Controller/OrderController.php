<?php

namespace AppBundle\Controller;

use AppBundle\Component\Response\CustomResponse;
use AppBundle\Component\Response\XmlResponse;
use AppBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

/**
 * Class OrderController
 * @package AppBundle\Controller
 */
class OrderController extends Controller
{

  /**
   * @Route("/api/order")
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
    $response = new CustomResponse($result, Response::HTTP_OK, [], $request);

    return $response->getResponse();
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

    if ($request->headers->get('Content-Type') == 'application/xml') {
      return new XmlResponse($result, Response::HTTP_OK, [], 'order');
    }

    return new JsonResponse($result, Response::HTTP_OK);

  }


  /**
   * @Route("/api/order")
   * @Method("POST")
   */
  public function newOrder(Request $request)
  {

    try {

      $content = $request->getContent();
      if (!is_string($content)) {

      }
    } catch (\Exception $ex) {

    }

    print_r($content);
    die;

    $user = $this->getDoctrine()->getManager()->getRepository(User::class);
    $user->find(1);

    $order = new Order();
    $order->setTitle('Keyboard');
    $order->setUser($user);

    $em = $this->getDoctrine()->getManager();
    $em->persist($order);
    $em->flush();

    return new Response($order, 201);
  }


}