<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EonX\EasyWebhook\Bridge\BridgeConstantsInterface;
use EonX\EasyWebhook\Middleware\IdHeaderMiddleware;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->tag(BridgeConstantsInterface::TAG_MIDDLEWARE)
        ->autoconfigure(false);

    $services
        ->set(IdHeaderMiddleware::class)
        ->arg('$idHeader', '%' . BridgeConstantsInterface::PARAM_ID_HEADER . '%');
};
