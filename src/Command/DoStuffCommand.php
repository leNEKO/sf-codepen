<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DoStuffCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        new QueryBuilder();
        $t = new ChoiceType();
        $this->setName('command:dostuff');
        $this->setDescription('This will do that');

        $this->addArgument(
            'what',
            InputArgument::REQUIRED,
            'the stuff'
        );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->writeln([
            'Hello',
            'World',
        ]);

        return 0;
    }
}
