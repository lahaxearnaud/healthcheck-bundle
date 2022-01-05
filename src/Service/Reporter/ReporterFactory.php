<?php

namespace Alahaxe\HealthCheckBundle\Service\Reporter;

use \RuntimeException;

class ReporterFactory
{
    public const CONTEXT_HTTP = 'http';
    public const CONTEXT_CLI = 'cli';

    public const TYPE_MINIMAL = 'minimal';
    public const TYPE_FULL = 'full';

    public function __construct(
        protected string $httpType,
        protected string $cliType,
    ) {
    }

    public function forge(string $context = self::CONTEXT_HTTP):ReporterInterface
    {
        if (!in_array($context, [self::CONTEXT_HTTP, self::CONTEXT_CLI], true)) {
            throw new RuntimeException(sprintf('Unknown context %s', $context));
        }

        if ($context === self::CONTEXT_HTTP) {
            $key = self::CONTEXT_HTTP.'_'.$this->httpType;
        } else {
            $key = self::CONTEXT_CLI.'_'.$this->cliType;
        }

        switch ($key) {
            case self::CONTEXT_CLI.'_'.self::TYPE_FULL:
                return new CliFullReporter();
            case self::CONTEXT_HTTP.'_'.self::TYPE_FULL:
                return new HttpFullReporter();
            case self::CONTEXT_HTTP.'_'.self::TYPE_MINIMAL:
                return new HttpMinimalReporter();
            default:
                throw new RuntimeException(sprintf('Reporter %s doesnt exist', $key));
        }
    }
}
