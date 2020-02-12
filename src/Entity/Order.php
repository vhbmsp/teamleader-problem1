<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Item;

class Order {

protected $id;
protected $customerId;
protected $customer;
protected $items;
protected $total;

public function __construct() {
    $this->id = null;
    $this->customerId = null;
    $this->customer = new Customer();
    $this->items = new ArrayCollection();
    $this->total = 0.0;
}

public function setId(int $id)
{
    $this->id = $id;

    return $this;
}

public function getId()
{
    return $this->id;
}

public function setCustomerId(int $customerId)
{
    $this->customerId = $customerId;

    return $this;
}

public function getCustomerId()
{
    return $this->customerId;
}

public function setCustomer(Customer $customer)
{
    $this->customer = $customer;

    return $this;
}

public function getCustomer()
{
    return $this->customer;
}

public function addItem(Item $item)
{

    if (false === $this->items->contains($item)) {
        $this->items->add($item);
    }

    return $this;
}

public function removeItem($item)
{
    if (true === $this->items->contains($item)) {
        $this->items->remove($item);
    }
    return $this;
}

public function getItems()
{
    return $this->items;
}

public function setTotal(float $total)
{
    $this->total = $total;
    return $this;
}

public function getTotal() {
    return $this->total;
}

public function calculateTotal()
{
    $total = 0.0;

    foreach ($this->items as $item) {

        if ($item->getQuantity() > 0) {
            $total+= $item->getQuantity() * $item->getUnitPrice();
        }
    }

    return $total;
}

}