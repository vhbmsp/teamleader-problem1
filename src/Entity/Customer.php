<?php
namespace App\Entity;

class Customer {

protected $id;
protected $name;
protected $since;
protected $revenue;


public function __construct()
{
    $this->id = 0;
    $this->name = null;
    $this->since = null;
    $this->revenue = 0.0;
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

public function setName($name)
{
    $this->name = $name;
    return $this;
}

public function getName()
{
    return $this->name;
}

public function setSince($since)
{
    $this->since = $since;
    return $this;
}

public function getSince()
{
    return $this->since;
}

public function setRevenue(float $revenue)
{
    $this->revenue = $revenue;
    return $this;
}

public function getRevenue() {
    return $this->revenue;
}

}