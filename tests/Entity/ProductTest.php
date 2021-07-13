<?php

namespace App\Entity;

class ProductTest extends \PHPUnit\Framework\TestCase
{

    private function createTestProduct()
    {
        $productData = [
            'Product Name' => 'tName',
            'Product Code' => 'tCode',
            'Product Description' => 'tDesc',
            'Cost in GBP' => 25.3,
            'Stock' => 8,
            'Discontinued' => 'yes',
        ];

        $product = new Product($productData);

        return $product;
    }

    private function callMethod($object, string $method , array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testGetCost()
    {
        $this->assertIsFloat($this->createTestProduct()->getCost());
    }

    public function testGetName()
    {
        $this->assertIsString($this->createTestProduct()->getName());
    }

    public function testGetCode()
    {
        $this->assertIsString($this->createTestProduct()->getCode());
    }

    public function testGetStock()
    {
        $this->assertIsInt($this->createTestProduct()->getStock());
    }

    public function testGetDescription()
    {
        $this->assertIsString($this->createTestProduct()->getDescription());
    }

    public function testSetDescription()
    {
        $newDesc = 'newDescription';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setDescription', ['description'=> $newDesc]);
        $this->assertEquals($testProd->getDescription(), $newDesc);
    }

    public function testSetCost()
    {
        $newCost = 100.55;
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd,'setCost', ['cost'=> $newCost]);
        $this->assertEquals($testProd->getCost(), $newCost);
    }

    public function testGetAdded()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getAdded());
    }

    public function testSetUpdated()
    {
        $newUpdated = new \DateTimeImmutable('+1 day');
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd,'setUpdated', ['updated' => $newUpdated]);
        $this->assertEquals($testProd->getUpdated(), $newUpdated);
    }

    public function testSetDiscontinued()
    {
        $newDiscounted = "yes";
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd,'setDiscontinued', ['discontinued' => $newDiscounted]);
        $this->assertNotEmpty($testProd->getDiscontinued());
    }

    public function testGetUpdated()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getUpdated());
    }

    public function testSetCode()
    {
        $newCode = 'newCode';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd,'setCode', ['code' => $newCode]);
        $this->assertEquals($testProd->getCode(), $newCode);
    }

    public function testGetDiscontinued()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getDiscontinued());
    }

    public function testSetAdded()
    {
        $newAdded = new \DateTimeImmutable('-3 day');
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd,'setAdded', ['added' => $newAdded]);
        $this->assertEquals($testProd->getAdded(), $newAdded);
    }

    public function testSetName()
    {
        $newName = 'newName';
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setName', ['name' => $newName]);
        $this->assertEquals($testProd->getName(), $newName);
    }

    public function testSetStock()
    {
        $newStock = 333;
        $testProd = $this->createTestProduct();
        $this->callMethod($testProd, 'setStock', ['stock' => $newStock]);
        $this->assertEquals($testProd->getStock(), $newStock);
    }
}
