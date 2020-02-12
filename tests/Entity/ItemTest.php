<?php
namespace App\Tests\Entity;

use App\Entity\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    // Test the creation of new Item Entity
    public function testItem()
    {
     	$item = new Item();

     	$item->setProductId("Z101");
     	$item->setQuantity(3);
     	$item->setUnitPrice(19.99);
        $item->setTotal(59.97);

        $this->assertEquals("Z101", $item->getProductId());
        $this->assertEquals(3, $item->getQuantity());
        $this->assertEquals(19.99, $item->getUnitPrice());
        $this->assertEquals(59.97, $item->getTotal());
    }
}