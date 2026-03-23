<?php

namespace App\Command;

use App\Entity\SoftwareVersion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-software',
    description: 'Import software versions from JSON file'
)]
class ImportSoftwareCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = dirname(__DIR__, 2) . '/public/assets/softwareversions.json';

        if (!file_exists($filePath)) {
            $output->writeln('<error>JSON file not found!</error>');
            return Command::FAILURE;
        }

        $jsonContent = file_get_contents($filePath);
        $data = json_decode($jsonContent, true);

        if (!$data) {
            $output->writeln('<error>Invalid JSON!</error>');
            return Command::FAILURE;
        }

        foreach ($data as $row) {

            $software = new SoftwareVersion();
            $software->setName($row['name'] ?? '');
            $software->setSystemVersion($row['system_version'] ?? '');
            $software->setSystemVersionAlt($row['system_version_alt'] ?? '');
            $software->setLink($row['link'] ?? '');
            $software->setSt($row['st'] ?? '');
            $software->setGd($row['gd'] ?? '');
            $software->setLatest($row['latest'] ?? false);

            $this->em->persist($software);
        }

        $this->em->flush();

        $output->writeln('<info>Import completed successfully!</info>');

        return Command::SUCCESS;
    }
}
