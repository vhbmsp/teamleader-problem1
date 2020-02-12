<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\Customer;


/**
 * CustomerRepository
 */
class CustomerRepository
{

    protected $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();

        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        // get customers from storage
        $customersList = json_decode(file_get_contents(dirname(__DIR__).'/../data/customers.json'));

        foreach($customersList as $customerItem) {
            $customer = $serializer->deserialize(json_encode($customerItem), Customer::class, 'json');
            $this->customers->add($customer);
        }
    }

    /*
     * get all available customers
     */

    public function getCustomers()
    {
        return $this->customers;
    }

    /*
     * Get a Customer by customerId
     */
    public function getCustomerById($customerId)
    {
        return $this->customers->filter(
            function ($customer) use ($customerId)  {
                return  ($customerId == $customer->getId());
            }
        )->current();

    }
}


