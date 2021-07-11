<?php

namespace App\Service;

use App\Repository\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function findAll() {

        $data = $this->productRepository->findAll();

        return $data;
    }

    public function findOneBy(array $criteria)
    {
        return $this->productRepository->findOneBy($criteria);
    }
}

