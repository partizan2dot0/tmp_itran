<?php

namespace App\Repository;

use App\Entity\FileParser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use League\Csv\Reader;

class FileParserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileParser::class);
    }

    public function loadData($filePath)
    {
        if (file_exists($filePath)) {
            $reader = Reader::createFromPath($filePath);
            $result = $reader->fetchAssoc();

            return $result;
        } else {
            return ['error' => "File does not exist. File path = $filePath "];
        }
    }

    public function fullData()
    {
        return [];
    }
}
