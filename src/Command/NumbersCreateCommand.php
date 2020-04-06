<?php

namespace App\Command;

use App\Entity\Numbers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class NumbersCreateCommand extends Command
{
    protected static $defaultName = 'app:numbers:create';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    protected function configure()
    {
        $this
            ->setDescription('Create new selection')
            ->addArgument('inputNumber', InputArgument::REQUIRED, 'Range of array')
            ->setHelp('Please give quantity of an array to check maximum value')
        ;
    }

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $inputNumber = $input->getArgument('inputNumber');

        if ((string)(int)$inputNumber == $inputNumber && $inputNumber > 0 && $inputNumber <= 99999) {
            $numbers = new Numbers();
            $numbers->setInputNumber($inputNumber);
            $this->em->persist($numbers);
            $this->em->flush();
            $io->success('Quantity: '.$inputNumber.' maximum value: '.$numbers->getResult());
        } else {
            $io->error('Quantity needs to be of number type in range between 0 to 99999');
        }

        return 0;
    }
}
