<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EonX\EasyWebhook\Bridge\BridgeConstantsInterface;
use EonX\EasyWebhook\Middleware\BodyFormatterMiddleware;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->tag(BridgeConstantsInterface::TAG_MIDDLEWARE)
        ->autoconfigure(false);

    // Body formatter
    $services->set(BodyFormatterMiddleware::class);
};
