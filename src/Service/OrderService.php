<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Item;

use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;

/**
 * Order Service
 */

class OrderService {

    protected $customerRepository;
    protected $productRepository;

    protected $activePromotions = ['customer_over_1000', 'switches_promotion', 'two_tool_items'];

    public function __construct(
        CustomerRepository $customerRepository,
        ProductRepository $productRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
    }

    /*
     * Decodes order from Json Request content
     */
    public function getOrderFromJson($content)
    {

        $order = new Order();

        // decode order from json
        $jsonOrder = json_decode($content);

        // set Order Properties
        $order->setId($jsonOrder->id);

        $customerId = $jsonOrder->{'customer-id'};
        $customer = $this->customerRepository->getCustomerById($customerId); // get Customer Obj from customerId

        $order->setCustomerId($customerId);
        $order->setCustomer($customer);

        $order->setTotal($jsonOrder->total);

        // add Order Items
        foreach($jsonOrder->items as $jsonItem) {

            $item = new Item();

            $productId = $jsonItem->{'product-id'};

            $product = $this->productRepository->getProductById($productId);

            $item->setProductId($productId);
            $item->setProduct($product);
            $item->setQuantity($jsonItem->quantity);
            $item->setUnitPrice($jsonItem->{'unit-price'});
            $item->setTotal($jsonItem->total);

            $order->addItem($item);
        }

        return $order;
    }

    /*
     * Checks if the Order has discounts
     */
    public function calculateDiscountFromOrder($order) {

        $discount = [
            'discount' => 0.0,
            'reason' => '',
        ];

        foreach($this->activePromotions as $promotion) {

            //verify if already applyed any discount, and exit
            if ($discount['discount'] > 0.0) {
                break;
            }

            switch ($promotion) {
                case 'customer_over_1000':
                    $discount = $this->promoCustomerOver1000($order);
                    break;
                case 'switches_promotion';
                    $discount = $this->promoSwitches($order);
                    break;

                case 'two_tool_items';
                    $discount = $this->promoTwoToolItems($order);
                    break;
            }

        }

        return $discount;

    }

    private function promoCustomerOver1000($order)
    {
        $discount = [
            'discount' => 0.0,
            'reason' => '',
        ];

        $customer = $order->getCustomer();

        if ($customer->getRevenue() > 1000) {

            $total = $order->getTotal();
            $discount['discount'] = $total * 0.20;
            $discount['reason'] = 'Premium Customer 10% discount';
        }

        return $discount;
    }

    private function promoSwitches($order)
    {
        $discount = [
            'discount' => 0.0,
            'reason' => '',
        ];

        $switchesItems = [];
        $switchesTotal = 0;

        $items = $order->getItems();

        // Since we can have several diferent Items from the Switch category, with different quantities
        // We first collect all switch Items and put them on a list, one element per quantity;
        foreach ($items as $item) {
            $product = $item->getProduct();

            // Verify Switch Category
            if (2 == $product->getCategory()) {
                // push N item prices to the list, as many as the item's quantity
                $switchesItems = array_merge(
                    $switchesItems,
                    array_fill(0, $item->getQuantity(), $item->getUnitPrice())
                );
                $switchesTotal += $item->getQuantity();
            }
        }

        for ($c = 1; $c <= $switchesTotal; $c++) {
            // Adds every 6th item price to total discount
            if ($c % 6 == 0) {
                $discount['discount'] += $switchesItems[$c-1];
                $discount['reason'] = '#' . ($c / 6) .' - Switch Discount';
            }
        }

        return $discount;
    }

    private function promoTwoToolItems($order)
    {
        $discount = [
            'discount' => 0.0,
            'reason' => '',
        ];

        $toolsItems = [];
        $toolsTotal = 0;

        $items = $order->getItems();

        // We first collect all Tools Items and put them on a list, one element per quantity;
        foreach ($items as $item) {
            $product = $item->getProduct();

            // Verify Tools Category
            if (1 == $product->getCategory()) {
                // push N item prices to the list, as many as the item's quantity
                $toolsItems = array_merge(
                    $toolsItems,
                    array_fill(0, $item->getQuantity(), $item->getUnitPrice())
                );
                $toolsTotal += $item->getQuantity();
            }
        }

        // Sort toolItems list to get lowest value first
        sort($toolsItems);

        // Adds every 6th item price to total discount
        if ($toolsTotal > 2) {
            $discount['discount'] += $toolsItems[0]; // get Cheapest Tool from list (item #0)
            $discount['reason'] = 'Tools Discount';
        }

        return $discount;
    }

}