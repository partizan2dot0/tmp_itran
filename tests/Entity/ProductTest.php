<?php

namespace App\Entity;


class ProductTest extends \PHPUnit\Framework\TestCase
{

    private $product = null;

    private function createTestProduct()
    {
        $now = new \DateTimeImmutable('now');

        $product  = (new Product())
            ->setName('tName')
            ->setCode('tCode')
            ->setDescription('tdesc')
            ->setCost(25.3)
            ->setStock(8)
            ->setAdded($now)
            ->setDiscontinued($now)
            ->setUpdated($now);
        return $product;
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
        $newDesc = "newDescription";
        $testProd = $this->createTestProduct()->setDescription($newDesc);
        $this->assertEquals($testProd->getDescription(), $newDesc);
    }

    public function testSetCost()
    {
        $newCost = 100.55;
        $testProd = $this->createTestProduct()->setCost($newCost);
        $this->assertEquals($testProd->getCost(), $newCost);
    }

    public function testGetAdded()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getAdded());
    }

    public function testSetUpdated()
    {
        $newUpdated = new \DateTimeImmutable('+1 day');
        $testProd = $this->createTestProduct()->setUpdated($newUpdated);
        $this->assertEquals($testProd->getUpdated(), $newUpdated);
    }

    public function testSetDiscontinued()
    {
        $newDiscounted = new \DateTimeImmutable('-1 day');
        $testProd = $this->createTestProduct()->setDiscontinued($newDiscounted);
        $this->assertEquals($testProd->getDiscontinued(), $newDiscounted);
    }

    public function testGetUpdated()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getUpdated());
    }

    public function testSetCode()
    {
        $newCode = "newCode";
        $testProd = $this->createTestProduct()->setCode($newCode);
        $this->assertEquals($testProd->getCode(), $newCode);
    }

    public function testGetDiscontinued()
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->createTestProduct()->getDiscontinued());
    }

    public function testSetAdded()
    {
        $newAdded = new \DateTimeImmutable('-3 day');
        $testProd = $this->createTestProduct()->setAdded($newAdded);
        $this->assertEquals($testProd->getAdded(), $newAdded);
    }

    public function testSetName()
    {
        $newName = "newName";
        $testProd = $this->createTestProduct()->setName($newName);
        $this->assertEquals($testProd->getName(), $newName);
    }

    public function testSetStock()
    {
        $newStock = 333;
        $testProd = $this->createTestProduct()->setStock($newStock);
        $this->assertEquals($testProd->getStock(), $newStock);
    }
}
