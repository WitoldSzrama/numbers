<?php

namespace App\Command;

use App\Entity\Numbers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NumbersCommand extends Command
{
    protected static $defaultName = 'app:numbers:history';
    /**
     * @var ContainerInterface
     */
    private $em;

    protected function configure()
    {
        $this
            ->setDescription('Print history of numbers');
    }

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $numbers = $this->em->getRepository(Numbers::class)->findAllDesc();
        $table = new Table($output);
        $rows = [];
        foreach ($numbers as $number) {
            $rows[] = [$number->getCreatedAt()->format('Y-m-d H:i:s'), $number->getInputNumber(),$number->getResult() ];
        }

        $table
            ->setHeaders(['Created at','Quantity', 'Maximum value' ])
            ->setRows($rows);
        $table->render();
        return 0;
    }
}
