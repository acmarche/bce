<?php

namespace AcMarche\Bce\Command;

use AcMarche\Bce\Search\SearchElastic;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'bce:search',
    description: 'Search',
)]
class ElasticSearcherCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('keyword', InputArgument::REQUIRED, 'mot clef');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $keyword = $input->getArgument('keyword');
        $io = new SymfonyStyle($input, $output);
        $elastic = new SearchElastic('bce');
        $result = $elastic->doSearch($keyword);

        dump($result);

        return Command::SUCCESS;
    }
}
