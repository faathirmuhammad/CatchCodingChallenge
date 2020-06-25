<?php

namespace App\Command;

use App\Entity\Product;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductCommand extends Command
{
    protected static $defaultName = 'product:seed';
    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this->setDescription('Seed products from CSV');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start CSV Seeding');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Seeding');

        $csv = array_map('str_getcsv', file('https://catch-code-challenge.s3-ap-southeast-2.amazonaws.com/products.csv'));

        $entityManager = $this->container->get('doctrine')->getManager();
        $entityManager->getConnection()->getConfiguration()->setSQLLogger(null);

        $batchSize = 25;
        for($i=1; $i<count($csv); $i++)
        {
            $product = new Product();
            $product->setUuid($csv[$i][0]);
            $product->setName($csv[$i][1]);
            $product->setSalePrice($csv[$i][2]);
            $product->setRetailPrice((int)$csv[$i][3]);
            $product->setImageUrl($csv[$i][4]);
            $product->setQuantityAvailable($csv[$i][5]);
            $entityManager->persist($product);
            if(($i % $batchSize === 0))
            {
                $entityManager->flush();
                $entityManager->clear();
            }
        }
        $entityManager->flush();
        $entityManager->clear();

        $output->writeln("Seeding Success !");
        return Command::SUCCESS;
    }
}
