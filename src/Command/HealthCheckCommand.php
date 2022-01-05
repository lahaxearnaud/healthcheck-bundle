<?php

namespace Alahaxe\HealthCheckBundle\Command;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Alahaxe\HealthCheckBundle\Service\Reporter\ReporterFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Response;

#[AsCommand(name: 'healthcheck')]
class HealthCheckCommand extends Command
{
    public function __construct(
        protected HealthCheckService $healthCheckService,
        protected ReporterFactory $reporterFactory
    ) {
        parent::__construct();
    }

    protected function configure():void
    {
        $this->setDescription('Health check command')
            ->addUsage('./bin/console healthcheck');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->section('Health check');

        $result = $this->healthCheckService->generateStatus();

        $reporter = $this->reporterFactory->forge(ReporterFactory::CONTEXT_CLI);

        $httpStatus = $reporter->calculateHttpCode($result);

        $io->table(
            [
                'Name',
                'Status',
                'Http Status',
                'Checker',
                'Payload'
            ],
            $reporter->format($result, [])
        );

        if ($httpStatus === Response::HTTP_OK) {
            $io->success('Ok');
            return self::SUCCESS;
        }

        if ($httpStatus === Response::HTTP_PARTIAL_CONTENT) {
            $io->warning('At least one warning');
            return self::SUCCESS;
        }

        $io->error('Ko');
        return self::FAILURE;
    }
}
