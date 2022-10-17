<?php

namespace MitinSany\PushCommon\Providers;

use Enqueue\AmqpLib\AmqpConnectionFactory;
use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\Extension\SignalExtension;
use Enqueue\Consumption\QueueConsumer;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Interop\Amqp\AmqpContext;
use Nikitakodo\EnqueueWrapper\AsyncSignalExtension;
use Nikitakodo\EnqueueWrapper\EnqueueListenerService;
use Nikitakodo\EnqueueWrapper\EnqueueMessageProducer;

class CommonServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(AmqpContext::class, function ($app) {
            $config = $app->get('config');
            $factory = new AmqpConnectionFactory([
                'host' => $config->get('amqp.host'),
                'port' => $config->get('amqp.port'),
                'vhost' => $config->get('amqp.vhost', '/'),
                'user' => $config->get('amqp.user'),
                'pass' => $config->get('amqp.password'),
                'persisted' => $config->get('amqp.persisted'),
            ]);
            return $factory->createContext();
        });

        $this->app->singleton(EnqueueListenerService::class, function ($app) {
            $context = $app->get(AmqpContext::class);
            $consumer = new QueueConsumer(
                $context,
                new ChainExtension([
                    extension_loaded('signal_handler')
                        ? new AsyncSignalExtension()
                        : new SignalExtension()
                ])
            );

            return new EnqueueListenerService($consumer);
        });

        $this->app->singleton(EnqueueMessageProducer::class, function ($app) {
            $context = $app->get(AmqpContext::class);
            return new EnqueueMessageProducer($context);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AmqpContext::class,
            EnqueueListenerService::class,
            EnqueueMessageProducer::class,
        ];
    }
}
