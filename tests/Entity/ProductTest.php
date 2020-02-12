<?php
namespace App\Tests\Entity;

use App\Entity\Product;
use App\Repository\ProductRepository;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    private $productRepository;

    public function setup() {
            $this->productRepository = new ProductRepository();
    }

    // Test the creation of new Product Entity
    public function testProduct()
    {
     	$product = new Product();

     	$product->setId(1);
     	$product->setDescription("Test");
     	$product->setCategory("xyz");
     	$product->setPrice(23.52);

        $this->assertEquals(1, $product->getId());
        $this->assertEquals("Test", $product->getDescription());
        $this->assertEquals("xyz", $product->getCategory());
        $this->assertEquals(23.52, $product->getPrice());
    }

    // Test that we load the products collection
    public function testGetAllProducts()
    {
        $products = $this->productRepository->getProducts();

        $this->assertEquals(5, $products->count());
    }

    // Test that we can find a products by Id
    public function testGetProductById()
    {

        $product = $this->productRepository->getProductById('A102');
        $this->assertEquals('A102', $product->getId());
        $this->assertEquals('Electric screwdriver', $product->getDescription());

        $product = $this->productRepository->getProductById('B103');
        $this->assertEquals('B103', $product->getId());
        $this->assertEquals('Switch with motion detector', $product->getDescription());

    }
}