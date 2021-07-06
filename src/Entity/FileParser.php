<?php

namespace App\Entity;

use App\Repository\FileParserRepository;
use Doctrine\ORM\Mapping as ORM;
use Egulias\EmailValidator\Result\Reason\Reason;
use League\Csv\Reader;

/**
 * @ORM\Entity(repositoryClass=FileParserRepository::class)
 */
class FileParser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public const IMPORT_RULES = "Import rules restrict inserting.";
    public const CODE_REPEATING  = "Product with this code already exist.";

    private $processedCount;
    private $skippedCount;
    private $successCount;
    private $skippedProducts;

    public function __construct()
    {
        $this->processedCount = 0;
        $this->skippedCount = 0;
        $this->successCount = 0;
        $this->skippedProducts = [];
    }

    public function incCounter($counterName): void
    {
        $this->{$counterName}++;
    }

    public function fixImportReject(array $product, string $rejectReason): void
    {
        $this->skippedProducts[] = $product['Product Name']." (".$product['Product Code']."). ".$rejectReason;
        $this->skippedCount++;
    }

    public function getCounter($counterName): int
    {
        return $this->{$counterName};
    }

    public function getSkippedProducts(): array
    {
        return $this->skippedProducts;
    }

}



