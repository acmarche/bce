<?php

namespace AcMarche\Bce\Command;

use AcMarche\Bce\Bce;
use AcMarche\Bce\Import\ImportHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'bce:import',
    description: 'Import bce csv files [all, activity, address, branch, code, contact, denomination, enterprise, establishment, meta]'
)]
class BceImportCommand extends Command
{
    public function __construct(
        private readonly ImportHandler $importHandler,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('fileName', InputArgument::REQUIRED, 'File name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fileName = $input->getArgument('fileName');

        if (!\in_array($fileName, Bce::$files, true)) {
            $io->warning('Missing file name. Possible values: '.implode(' ', Bce::$files));

            return Command::FAILURE;
        }

        if ('all' === $fileName) {
            try {
                $this->importHandler->importAll();
            } catch (\Exception $e) {
                $io->error($e->getMessage());
            }

            return Command::SUCCESS;
        }

        try {
            $handler = $this->importHandler->loadHandlerByKey($fileName);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        try {
            $handler->start();
            foreach ($handler->readFile($fileName) as $data) {
                $io->writeLn($handler->writeLn($data));
                $handler->handle($data);
                $handler->flush();
                $io->writeln('Memory'.memory_get_usage());
            }

            $handler->flush();
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
