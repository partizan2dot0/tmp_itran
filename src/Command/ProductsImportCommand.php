<?php

namespace App\Command;

use App\Entity\FileParser;
use App\Entity\Product;
use App\Repository\FileParserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ProductService;
use App\Service\FileParserService;

class ProductsImportCommand extends Command
{
    protected static $defaultDescription = 'import products from *.csv file';

    private $entityManager;
    private $container;
    private $productService;
    private $fileParserService;

    private $processedCount = 0;

    public function __construct(EntityManagerInterface $em, ContainerInterface $cont, ProductService $productService, FileParserService $fileParserService)
    {
        parent::__construct();

        $this->entityManager = $em;
        $this->container = $cont;
        $this->productService = $productService;
        $this->fileParserService = $fileParserService;
    }

    protected function configure(): void
    {
        $this->addOption('testMode', null, InputOption::VALUE_NONE, 'is test mode enabled');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $testMode = $input->getOption('testMode');  // if running:  products:import --testMode  == test mode;

        $now = new \DateTimeImmutable('now');

        $filePath = $this->container->getParameter('filepath');

        $fileData = $this->fileParserService->loadData($filePath);

        if (!is_object($fileData)) {
            $output->writeln('<error>'.$fileData['error'].'</error>');

            return self::FAILURE; // File reading error
        }

        $parser = new FileParser();
        foreach ($fileData as $fileRow) {
            $product = $this->productService->findOneBy([
                'code' => $fileRow['Product Code'],
            ]);

            if (null === $product) {     // if product absent in database
                if (Product::checkConditions($fileRow)) {
                    $parser->fixImportReject($fileRow, $parser::IMPORT_RULES);
                } else {
                    $product = new Product($fileRow);

                    if (!$testMode) { // NO any actions in database during  test mode
                        $this->entityManager->persist($product);
                        $this->entityManager->flush();
                    }
                    $parser->incCounter('successCount');
                }
            } else {
                $parser->fixImportReject($fileRow, $parser::CODE_REPEATING);
            }
            ++$this->processedCount;
            $parser->incCounter('processedCount');
        }

        $output->writeln('<info>Counters:</info>');
        $output->writeln('Records processed: '.$parser->getCounter('processedCount'));
        $output->writeln('Records inserted: '.$parser->getCounter('successCount'));
        $output->writeln('Records skipped: '.$parser->getCounter('skippedCount'));

        if ($parser->getCounter('skippedCount') > 0) {
            $output->writeln('<error>Skipped records:</error>');
            foreach ($parser->getSkippedProducts() as $sp) {
                $output->writeln($sp);
            }
        }

        return Command::SUCCESS;
    }
}
