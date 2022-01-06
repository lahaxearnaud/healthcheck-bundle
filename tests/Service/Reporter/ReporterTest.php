<?php

namespace Alahaxe\HealthCheckBundle\Tests\Service\Reporter;

use Alahaxe\HealthCheck\Contracts\CheckStatus;
use Alahaxe\HealthCheck\Contracts\CheckStatusInterface;
use Alahaxe\HealthCheckBundle\Service\Check\AppCheck;
use Alahaxe\HealthCheckBundle\Service\Reporter\CliFullReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\HttpFullReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\HttpMinimalReporter;
use Alahaxe\HealthCheckBundle\Service\Reporter\ReporterFactory;
use PHPUnit\Framework\TestCase;

class ReporterTest extends TestCase
{
    /**
     * @dataProvider resultDataProvider
     */
    public function testHttpFullReporter(array $result, int $httpStatus)
    {
        $reporter = new HttpFullReporter();
        $report = $reporter->format($result, [
            'foo' => 'bar'
        ]);
        $this->assertIsArray($report);
        $this->assertIsArray($report['checks']);
        $this->assertInstanceOf(CheckStatusInterface::class, $report['checks']['app']);
        $this->assertIsArray($report['context']);
        $this->assertIsBool($report['health']);
        $status = $reporter->calculateHttpCode($result);
        $this->assertEquals($status, $httpStatus);
    }

    /**
     * @dataProvider resultDataProvider
     */
    public function testHttpMinimalReporter(array $result, int $httpStatus)
    {
        $reporter = new HttpMinimalReporter();
        $report = $reporter->format($result, [
            'foo' => 'bar'
        ]);
        $this->assertIsArray($report);
        $this->assertCount(1, array_keys($report));
        $this->assertIsBool($report['health']);
        $status = $reporter->calculateHttpCode($result);
        $this->assertEquals($status, $httpStatus);
    }

    /**
     * @dataProvider resultDataProvider
     */
    public function testCliFullReporter(array $result, int $httpStatus)
    {
        $reporter = new CliFullReporter();
        $report = $reporter->format($result, [
            'foo' => 'bar'
        ]);
        $this->assertIsArray($report);

        foreach ($report as $value) {
            $this->assertIsArray($value);
            foreach ($value as $col) {
                if ($col === null) {
                    continue;
                }

                $this->assertIsScalar($col);
            }
        }

        $status = $reporter->calculateHttpCode($result);
        $this->assertEquals($status, $httpStatus);
    }



    public function resultDataProvider():array
    {
        return [
            [
                [
                    'app' => new CheckStatus('app', AppCheck::class, CheckStatusInterface::STATUS_OK)
                ],
                200
            ],
            [
                [
                    'app' => new CheckStatus('app', AppCheck::class, CheckStatusInterface::STATUS_WARNING)
                ],
                200
            ],
            [
                [
                    'app' => new CheckStatus('app', AppCheck::class, CheckStatusInterface::STATUS_INCIDENT)
                ],
                503
            ],
            [
                [
                    'app' => new CheckStatus('app', AppCheck::class, CheckStatusInterface::STATUS_OK),
                    'app2' => new CheckStatus('app2', AppCheck::class, CheckStatusInterface::STATUS_INCIDENT)
                ],
                503
            ]
        ];
    }
}
