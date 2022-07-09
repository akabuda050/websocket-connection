<?php

namespace JsonBaby\WebsocketConnection;

use Illuminate\Support\ServiceProvider;
use JsonBaby\EventBridge\Interfaces\Connections\PubSubConnectionInterface;
use JsonBaby\WebsocketConnection\Console\InstallWebsocketConnectionCommand;
use JsonBaby\WebsocketConnection\Entities\WebSocketConnection;
use WebSocket\Client;

class WebsocketConnectionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/websocket-connection.php' => config_path('websocket-connection.php'),
            ], 'websocket-connection-config');

            $this->commands([
                InstallWebsocketConnectionCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/websocket-connection.php', 'websocket-connection');

        // Register the main class to use with the facade
        $this->app->singleton(PubSubConnectionInterface::class, function ($app): WebSocketConnection {
            return new WebSocketConnection(
                new Client(
                    $app->config['websocket-connection.websocket_uri'],
                    $app->config['websocket-connection.options']
                )
            );
        });
    }
}
