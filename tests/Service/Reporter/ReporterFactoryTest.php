<?php

namespace Alahaxe\HealthCheckBundle\Tests\Service\Reporter;

use Alahaxe\HealthCheckBundle\Service\Reporter\CliFullReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\HttpFullReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\HttpMinimalReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\ReporterFactory;
use PHPUnit\Framework\TestCase;

class ReporterFactoryTest extends TestCase
{
    public function testCanCreateHttpMinimal()
    {
        $factory = new ReporterFactory(ReporterFactory::TYPE_MINIMAL, ReporterFactory::TYPE_FULL);
        $result = $factory->forge(ReporterFactory::CONTEXT_HTTP);
        $this->assertInstanceOf(HttpMinimalReporter::class, $result);
    }

    public function testCanCreateHttpFull()
    {
        $factory = new ReporterFactory(ReporterFactory::TYPE_FULL, ReporterFactory::TYPE_FULL);
        $result = $factory->forge(ReporterFactory::CONTEXT_HTTP);
        $this->assertInstanceOf(HttpFullReporter::class, $result);
    }

    public function testCanCreateCliFull()
    {
        $factory = new ReporterFactory(ReporterFactory::TYPE_MINIMAL, ReporterFactory::TYPE_FULL);
        $result = $factory->forge(ReporterFactory::CONTEXT_CLI);
        $this->assertInstanceOf(CliFullReporter::class, $result);
    }

    public function testCantCreateWithBadContext()
    {
        $this->expectException(\RuntimeException::class);
        $factory = new ReporterFactory(ReporterFactory::TYPE_MINIMAL, ReporterFactory::TYPE_FULL);
        $result = $factory->forge('foo');
        $this->assertInstanceOf(CliFullReporter::class, $result);
    }

    public function testCantCreateWithBadType()
    {
        $this->expectException(\RuntimeException::class);
        $factory = new ReporterFactory('foo', ReporterFactory::TYPE_FULL);
        $result = $factory->forge(ReporterFactory::CONTEXT_HTTP);
        $this->assertInstanceOf(CliFullReporter::class, $result);
    }
}
