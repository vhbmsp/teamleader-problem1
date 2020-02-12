<?php
namespace App\Tests\Entity;

use App\Entity\Customer;
use App\Repository\CustomerRepository;

use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

    private $customerRepository;

    public function setup()
    {
        $this->customerRepository = new CustomerRepository();
    }


    // Test the creation of new Customer Entity
    public function testCustomer()
    {
     	$customer = new Customer();

     	$customer->setId(1);
     	$customer->setName("Vasco Pinheiro");
     	$customer->setSince("2020-01-23");
     	$customer->setRevenue(2500.99);

        $this->assertEquals(1, $customer->getId());
        $this->assertEquals("Vasco Pinheiro", $customer->getName());
        $this->assertEquals("2020-01-23", $customer->getSince());
        $this->assertEquals(2500.99, $customer->getRevenue());
    }


    // Test that we load the products collection
    public function testGetAllCustomers()
    {
        $customer = $this->customerRepository->getCustomers();
        $this->assertEquals(3, $customer->count());
    }

    // Test that we can find a customer by Id
    public function testGetCustomerById()
    {

        $customer = $this->customerRepository->getcustomerById(1);
        $this->assertEquals(1, $customer->getId());
        $this->assertEquals('Coca Cola', $customer->getName());

        $customer = $this->customerRepository->getcustomerById(3);
        $this->assertEquals(3, $customer->getId());
        $this->assertEquals('Jeroen De Wit', $customer->getName());

    }
}