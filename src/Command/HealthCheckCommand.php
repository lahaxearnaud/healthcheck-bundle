<?php

namespace Alahaxe\HealthCheckBundle\Command;

use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
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
        protected HealthCheckService $healthCheckService
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

        $httpStatus = max(array_map(static function (CheckStatusInterface $checkStatus):int {
            return $checkStatus->getHttpStatus();
        }, $result));

        $io->table(
            [
                'Name',
                'Status',
                'Http Status',
                'Checker',
                'Payload'
            ],
            array_map(
                static function (CheckStatusInterface $checkStatus):array {
                    return [
                        $checkStatus->getAttributeName(),
                        $checkStatus->getStatus(),
                        $checkStatus->getHttpStatus(),
                        $checkStatus->getCheckerClass(),
                        $checkStatus->getPayload(),
                    ];
                },
                $result
            )
        );

        if ($httpStatus === Response::HTTP_OK) {
            $io->success('Ok');
            return self::SUCCESS;
        }

        $io->success('Ko');
        return self::FAILURE;
    }
}
