<?php

namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\Product;


/**
 * ProductRepository
 */
class ProductRepository
{

    protected $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();

        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);

        // get products from storage
        $productsList = json_decode(file_get_contents(dirname(__DIR__).'/../data/products.json'));

        foreach($productsList as $productItem) {
            $product = $serializer->deserialize(json_encode($productItem), Product::class, 'json');
            $this->products->add($product);
        }
    }

    /*
     * get all available products
     */

    public function getProducts()
    {
        return $this->products;
    }

    /*
     * Get a Product by ProductId
     */
    public function getProductById($productId)
    {
        return $this->products->filter(
            function ($product) use ($productId)  {
                return  ($productId == $product->getId());
            }
        )->current();

    }
}


