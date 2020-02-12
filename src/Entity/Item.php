<?php
namespace App\Entity;

use App\Entity\Product;

class Item {

protected $productId;
protected $product;
protected $quantity;
protected $unitPrice;
protected $total;

public function __construct()
{
    $productId = null;
    $product = new Product();
    $quantity = 0;
    $unitPrice = 0.0;
    $total = 0.0;
}

public function setProductId($productId)
{
    $this->productId = $productId;
    return $this;
}

public function getProductId()
{
    return $this->productId;
}

public function setProduct(Product $product)
{
    $this->product = $product;
    return $this;
}

public function getProduct()
{
    return $this->product;
}

public function setQuantity(int $quantity)
{
    $this->quantity = $quantity;
    return $this;
}

public function getQuantity()
{
    return $this->quantity;
}

public function setUnitPrice(float $unitPrice)
{
    $this->unitPrice = $unitPrice;
}

public function getUnitPrice()
{
    return $this->unitPrice;
}

public function setTotal(float $total)
{
    $this->total = $total;
    return $this;
}

public function getTotal()
{
    return $this->total;
}

}