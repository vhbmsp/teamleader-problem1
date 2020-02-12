<?php
namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\Order;

use App\Service\OrderService;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class OrderServiceTest extends WebTestCase
{

    protected $orderService;

    public function setup()
    {
        self::bootKernel();
        $this->orderService = self::$container->get('App\Service\OrderService');
    }

    // Test the creation of new Order Entity
    public function testOrderFromJson()
    {

        $orderJson = '{
          "id": "1",
          "customer-id": "1",
          "items": [
            {
              "product-id": "B102",
              "quantity": "10",
              "unit-price": "4.99",
              "total": "49.90"
            }
          ],
          "total": "49.90"
        }';

        $order = $this->orderService->getOrderFromJson($orderJson);

        $this->assertEquals(1, $order->getId());

        $this->assertEquals(1, $order->getCustomerId());
        $this->assertEquals(1, $order->getCustomer()->getId()); // ID from Customer Object

        $item = $order->getItems()->first();

        $this->assertEquals("B102", $item->getProductId());
        $this->assertEquals("B102", $item->getProduct()->getId()); // ID from Product Object

        $this->assertEquals(49.90, $order->getTotal());
    }

    // Test Order 1:  Switch Discount
    public function testOrder1()
    {

        $orderJson = '{
          "id": "1",
          "customer-id": "1",
          "items": [
            {
              "product-id": "B102",
              "quantity": "10",
              "unit-price": "4.99",
              "total": "49.90"
            }
          ],
          "total": "49.90"
        }';

        $order = $this->orderService->getOrderFromJson($orderJson);
        $result = $this->orderService->calculateDiscountFromOrder($order);
        $this->assertEquals(4.99, $result['discount']);

        // Same order with more quantity
        $orderJson2 = '{
          "id": "1",
          "customer-id": "1",
          "items": [
            {
              "product-id": "B102",
              "quantity": "25",
              "unit-price": "4.99",
              "total": "49.90"
            }
          ],
          "total": "49.90"
        }';

        $order2 = $this->orderService->getOrderFromJson($orderJson2);
        $result2 = $this->orderService->calculateDiscountFromOrder($order2);
        $this->assertEquals(19.96, $result2['discount']);

    }

    // Test Order 2: Premium Customer 10% discount
    public function testOrder2()
    {

        $orderJson = '{
          "id": "2",
          "customer-id": "2",
          "items": [
            {
              "product-id": "B102",
              "quantity": "5",
              "unit-price": "4.99",
              "total": "24.95"
            }
          ],
          "total": "24.95"
        }';

        $order = $this->orderService->getOrderFromJson($orderJson);
        $result = $this->orderService->calculateDiscountFromOrder($order);
        $this->assertEquals(4.99, $result['discount']);
    }


    // Test Order 3: Tool Discount
    public function testOrder3()
    {

        $orderJson = '{
          "id": "3",
          "customer-id": "3",
          "items": [
            {
              "product-id": "A101",
              "quantity": "2",
              "unit-price": "9.75",
              "total": "19.50"
            },
            {
              "product-id": "A102",
              "quantity": "1",
              "unit-price": "49.50",
              "total": "49.50"
            }
          ],
          "total": "69.00"
        }';

        $order = $this->orderService->getOrderFromJson($orderJson);
        $result = $this->orderService->calculateDiscountFromOrder($order);
        $this->assertEquals(9.75, $result['discount']);

        // Same order but first item costs more, gives discount on 2 item
        $orderJson2 = '{
          "id": "3",
          "customer-id": "3",
          "items": [
            {
              "product-id": "A101",
              "quantity": "2",
              "unit-price": "69.75",
              "total": "139.5"
            },
            {
              "product-id": "A102",
              "quantity": "1",
              "unit-price": "49.50",
              "total": "49.50"
            }
          ],
          "total": "189.00"
        }';

        $order2 = $this->orderService->getOrderFromJson($orderJson2);
        $result2 = $this->orderService->calculateDiscountFromOrder($order2);
        $this->assertEquals(49.50, $result2['discount']);
    }

}