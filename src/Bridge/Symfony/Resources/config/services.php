<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EonX\EasyWebhook\Bridge\BridgeConstantsInterface;
use EonX\EasyWebhook\Formatters\JsonFormatter;
use EonX\EasyWebhook\HttpClientFactory;
use EonX\EasyWebhook\Interfaces\HttpClientFactoryInterface;
use EonX\EasyWebhook\Interfaces\WebhookBodyFormatterInterface;
use EonX\EasyWebhook\Interfaces\WebhookClientInterface;
use EonX\EasyWebhook\Interfaces\WebhookResultHandlerInterface;
use EonX\EasyWebhook\Interfaces\WebhookRetryStrategyInterface;
use EonX\EasyWebhook\Interfaces\WebhookStoreInterface;
use EonX\EasyWebhook\RetryStrategies\NullWebhookRetryStrategy;
use EonX\EasyWebhook\Stores\NullWebhookStore;
use EonX\EasyWebhook\WebhookClient;
use EonX\EasyWebhook\WebhookResultHandler;
use Symfony\Component\HttpClient\HttpClient;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    // Body Formatter (Default)
    $services->set(WebhookBodyFormatterInterface::class, JsonFormatter::class);

    // HTTP Client
    $services
        // Factory
        ->set(HttpClientFactoryInterface::class, HttpClientFactory::class)
        // Client
        ->set(BridgeConstantsInterface::HTTP_CLIENT, HttpClient::class)
        ->factory([ref(HttpClientFactoryInterface::class), 'create']);

    // Webhook Retry Strategy (Default)
    $services->set(WebhookRetryStrategyInterface::class, NullWebhookRetryStrategy::class);

    // Webhook Result Handler
    $services->set(WebhookResultHandlerInterface::class, WebhookResultHandler::class);

    // Webhook Client
    $services
        ->set(WebhookClientInterface::class, WebhookClient::class)
        ->arg('$configurators', tagged_iterator(BridgeConstantsInterface::TAG_WEBHOOK_CONFIGURATOR))
        ->arg('$httpClient', ref(BridgeConstantsInterface::HTTP_CLIENT));

    // Webhook Store (Default)
    $services->set(WebhookStoreInterface::class, NullWebhookStore::class);
};
