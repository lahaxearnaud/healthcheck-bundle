# HealthCheck Bundle

[![DeepSource](https://deepsource.io/gh/lahaxearnaud/healthcheck-bundle.svg/?label=active+issues&show_trend=true&token=2TynA5-OU1ADI4SRD-GRlgVF)](https://deepsource.io/gh/lahaxearnaud/healthcheck-bundle/?ref=repository-badge)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/alahaxe/healthcheck-bundle)
![Packagist Version](https://img.shields.io/packagist/v/alahaxe/healthcheck-bundle)
![GitHub Workflow Status (branch)](https://img.shields.io/github/workflow/status/lahaxearnaud/healthcheck-bundle/CI/main)

This bundle allows to easily expose a healthcheck on a Symfony application.
You can add as many checks you want and create your own checks.


## Installation

```bash
    composer require alahaxe/healthcheck-bundle
```

## Quickstart

### Router

Register package routes in your application

```yaml
lahaxearnaud_healthcheck:
    resource: "@HealthCheckBundle/Resources/config/router.yaml"
```

Default route for healthcheck is `/_healthcheck`


### Firewall

Allow any requests to call the healthcheck endpoint.

```yaml
security:
    firewalls:
        healthcheck:
            pattern: ^/_healthcheck
            security: false

```

### Use custom route

Do not load resource `@HealthCheckBundle/Resources/config/router.yaml` file in your router but add:

```yaml
lahaxearnaud_healthcheck:
    path: /my-healthcheck
    controller: Alahaxe\HealthCheckBundle\Controller\HealthCheckController
```

Adapt firewall pattern:

```yaml
security:
    firewalls:
        healthcheck:
            pattern: ^/my-healthcheck
            security: false
```

## Documentation

### Use available checks

| Name               | Package            | Current version    |
|--------------------|--------------------|--------------------|
| Doctrine check     |[alahaxe/healthcheck-doctrine](https://packagist.org/packages/alahaxe/healthcheck-doctrine)|![Packagist Version](https://img.shields.io/packagist/v/alahaxe/healthcheck-doctrine)|
| System check       |[alahaxe/healthcheck-system](https://packagist.org/packages/alahaxe/healthcheck-system)    |![Packagist Version](https://img.shields.io/packagist/v/alahaxe/healthcheck-system)|
| Redis check        |[alahaxe/healthcheck-redis](https://packagist.org/packages/alahaxe/healthcheck-redis)    |![Packagist Version](https://img.shields.io/packagist/v/alahaxe/healthcheck-redis)|
| Curl check        |[alahaxe/healthcheck-redis](https://packagist.org/packages/alahaxe/healthcheck-curl)    |![Packagist Version](https://img.shields.io/packagist/v/alahaxe/healthcheck-curl)|


### Add a custom check

Create a custom class that implements `CheckInterface`:

```php
<?php

namespace App\Service\HealthCheck;

use Alahaxe\HealthCheckBundle\CheckStatus;
use Alahaxe\HealthCheckBundle\Contract\CheckInterface;

class AppCheck implements CheckInterface
{
    public function check(): CheckStatus
    {
        return new CheckStatus(
            'app', // the name in the final json
            __CLASS__, // only for debug
            CheckStatus::STATUS_OK, // or CheckStatus::STATUS_WARNING or CheckStatus::STATUS_INCIDENT
            'An optional message, publicly exposed',
            200 // an HTTP status
        );
    }
}
```

The output on `/_healthcheck` will be:

````json
{
    "checks": {
        "app": {
            "payload": "An optional message, publicly exposed",
            "status": "ok"
        }
    }
}
````

Register the service with the tag `lahaxearnaud.healthcheck.check` :

```yaml
    App\Service\HealthCheck\AppCheck:
        tags: ['lahaxearnaud.healthcheck.check']
```

Or if you have many checks you can add the tag on a folder:

```yaml
    App\Service\HealthCheck\:
        resource: '../src/Service/HealthCheck'
        tags: ['lahaxearnaud.healthcheck.check']
```

## License

This bundle is under the MIT license. See the complete license [in the bundle](LICENSE).
