<?php


namespace App\Service;

use App\Repository\FileParserRepository;

class FileParserService
{
    private $fileName = "stock.csv";

    private $fileParserRepository;

    public function __construct(FileParserRepository $fileParserRepository)
    {
        $this->fileParserRepository = $fileParserRepository;
    }

    public function loadData(string $filePath) {

        $data = $this->fileParserRepository->loadData($filePath.$this->fileName);

        return $data;
    }
}

