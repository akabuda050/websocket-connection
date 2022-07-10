<?php

namespace JsonBaby\WebSocketPubSub;

use Illuminate\Support\ServiceProvider;
use JsonBaby\PubSubBase\Interfaces\ClientInterface;
use JsonBaby\PubSubBase\Interfaces\PubSubInterface;
use JsonBaby\WebSocketPubSub\Console\InstallWebSocketPubSubCommand;
use JsonBaby\WebSocketPubSub\Entities\WebSocketClient;
use JsonBaby\WebSocketPubSub\Entities\WebSocketPubSub;

class WebSocketPubSubServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/websocket-pubsub.php' => config_path('websocket-pubsub.php'),
            ], 'websocket-pubsub-config');

            $this->commands([
                InstallWebSocketPubSubCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/websocket-pubsub.php', 'websocket-pubsub');

        $this->app->singleton(ClientInterface::class, function ($app): WebSocketClient {
            return new WebSocketClient(
                $app->config['websocket-pubsub.websocket_uri'],
                $app->config['websocket-pubsub.options']
            );
        });

        $this->app->singleton(PubSubInterface::class, function ($app): WebSocketPubSub {
            return new WebSocketPubSub(
                $app->make(ClientInterface::class)
            );
        });
    }
}
