<?php
namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    // Test the creation of new Order Entity
    public function testOrder()
    {
     	$order = new Order();

     	$order->setId(1);
     	$order->setCustomerId(3);
        $order->setTotal(69);

        $this->assertEquals(1, $order->getId());
        $this->assertEquals(3, $order->getCustomerId());
        $this->assertEquals(69, $order->getTotal());
    }

    // Test add Items to the new Order Entity
    public function testOrderAddItems()
    {

        $item1= new Item();
        $item2= new Item();
        $order = new Order();

        $item1->setProductId("A101");
        $item1->setQuantity(2);
        $item1->setUnitPrice(9.75);
        $item1->setTotal(19.50);

        $item2->setProductId("A102");
        $item2->setQuantity(1);
        $item2->setUnitPrice(49.50);
        $item2->setTotal(49.50);

        $order->addItem($item1);
        $order->addItem($item2);

        $this->assertEquals(69.00, $order->calculateTotal()); // test the calc of order the total from items

        //retrieve the two order's items
        $firstItem = $order->getItems()->first();
        $secondItem = $order->getItems()->next();

        $this->assertEquals($item1, $firstItem);
        $this->assertEquals($item2, $secondItem);
    }
}