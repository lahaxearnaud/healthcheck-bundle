<?php

namespace Alahaxe\HealthCheckBundle\Tests\Command;

use Alahaxe\HealthCheckBundle\Command\HealthCheckCommand;
use Alahaxe\HealthCheckBundle\Service\Check\AppCheck;
use Alahaxe\HealthCheckBundle\Service\HealthCheckService;
use Alahaxe\HealthCheckBundle\Tests\Fixture\ExceptionCheck;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

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
            []
        );
        $command = new HealthCheckCommand($healthCheckService);
        $tester = new CommandTester(
            $command
        );

        $tester->execute([]);
        $output = $tester->getDisplay();
        $this->assertStringContainsString(ExceptionCheck::class, $output);
        $this->assertEquals(Command::FAILURE, $tester->getStatusCode());
    }
}
