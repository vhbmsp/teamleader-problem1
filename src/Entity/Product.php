<?php
namespace App\Entity;

class Product {

protected $id;
protected $description;
protected $category;
protected $price;


public function __construct() {
    $this->id = 0;
    $this->description = null;
    $this->category = null;
    $this->price = 0.0;
}

public function setId($id)
{
    $this->id = $id;
    return $this;
}

public function getid()
{
    return $this->id;
}

public function setDescription($description)
{
    $this->description = $description;
    return $this;
}

public function getDescription()
{
    return $this->description;
}

public function setCategory($category)
{
    $this->category = $category;
    return $this;
}

public function getCategory()
{
    return $this->category;
}

public function setPrice(float $price)
{
    $this->price = $price;
    return $this;
}

public function getPrice()
{
    return $this->price;
}

}