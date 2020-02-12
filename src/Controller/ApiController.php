<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\Client;
use App\Entity\Order;
use App\Repository\ProductRepository;
use App\Service\OrderService;

/**
 * Class ApiController.
* @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{

    protected $productRepository;

    public function __construct(OrderService $orderService, ProductRepository $productRepository) {

        $this->orderService = $orderService;
        $this->productRepository = $productRepository;

    }

    /**
     * @Route("/", name="index")
     * @return Response|JsonResponse
     */
    public function indexAction(Request $request)
    {

        $response = ['api_request' => true];

        return new JsonResponse($response);;

    }


    /**
     * @Route("/promo", name="promotion")
     * @return Response|JsonResponse
     */
    public function promotionAction(Request $request)
    {

        $response = [];

        if ($request->isMethod('post')) {

            if ($content = $request->getContent()) {
                $order = $this->orderService->getOrderFromJson($content);
            }

            $response['discount'] = $this->orderService->calculateDiscountFromOrder($order);

        }

        return new JsonResponse($response);;
    }

}