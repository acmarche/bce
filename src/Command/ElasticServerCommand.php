<?php

namespace AcMarche\Bce\Command;

use AcMarche\Bce\Elasticsearch\ElasticServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'bce:server',
    description: 'RazIndex',
)]
class ElasticServerCommand extends Command
{
    private ?SymfonyStyle $io = null;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Raz. Êtes vous sur ? (Y,N) ', false);

        if (!$helper->ask($input, $output, $question)) {
            return Command::SUCCESS;
        }

        $elastic = new ElasticServer();
        $elastic->createIndex();
        $elastic->setMapping();

        $this->io->success('Index vidé');

        return Command::SUCCESS;
    }
}
