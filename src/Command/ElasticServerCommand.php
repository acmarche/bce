<?php

namespace AcMarche\Bce\Command;

use AcMarche\Bce\Elasticsearch\ElasticServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class ElasticServerCommand extends Command
{
    protected static $defaultName = 'bce:server';
    private ?SymfonyStyle $io = null;

    protected function configure(): void
    {
        $this
            ->setDescription('Raz l\'index');
    }

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
