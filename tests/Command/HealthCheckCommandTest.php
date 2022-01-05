<?php

namespace Alahaxe\HealthCheckBundle\Tests\Command;

use Alahaxe\HealthCheckBundle\Command\HealthCheckCommand;
use Alahaxe\HealthCheckBundle\Service\Check\AppCheck;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Alahaxe\HealthCheckBundle\Service\Reporter\ReporterFactory;
use Alahaxe\HealthCheckBundle\Tests\Fixture\ExceptionCheck;
use Alahaxe\HealthCheckBundle\Tests\Fixture\WarningCheck;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HealthCheckCommandTest extends KernelTestCase
{
    protected function setUp():void
    {
        parent::setUp();

        self::bootKernel();
    }

    public function testThatCliHealthCheckCanRun()
    {
        /** @var HealthCheckCommand $command */
        $command = self::getContainer()->get(HealthCheckCommand::class);
        $tester = new CommandTester(
            $command
        );

        $tester->execute([]);
        $tester->assertCommandIsSuccessful();
        $output = $tester->getDisplay();
        // default checker is in output
        $this->assertStringContainsString(AppCheck::class, $output);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }

    public function testThatCliHealthCheckWithError()
    {
        $healthCheckService = new HealthCheckService(
            [new ExceptionCheck()],
            [],
            new EventDispatcher()
        );
        $command = new HealthCheckCommand($healthCheckService, new ReporterFactory(ReporterFactory::TYPE_FULL, ReporterFactory::TYPE_FULL));
        $tester = new CommandTester(
            $command
        );

        $tester->execute([]);
        $output = $tester->getDisplay();
        $this->assertStringContainsString(ExceptionCheck::class, $output);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
    }

    public function testThatCliHealthCheckWithWarning()
    {
        $healthCheckService = new HealthCheckService(
            [new WarningCheck()],
            [],
            new EventDispatcher()
        );
        $command = new HealthCheckCommand($healthCheckService, new ReporterFactory(ReporterFactory::TYPE_FULL, ReporterFactory::TYPE_FULL));
        $tester = new CommandTester(
            $command
        );

        $tester->execute([]);
        $output = $tester->getDisplay();
        $this->assertStringContainsString(WarningCheck::class, $output);
        $this->assertEquals(Command::SUCCESS, $tester->getStatusCode());
    }
}
