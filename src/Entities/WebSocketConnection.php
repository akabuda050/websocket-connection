<?php

namespace JsonBaby\WebsocketConnection\Entities;

use Closure;
use JsonBaby\EventBridge\Interfaces\Connections\PubSubConnectionInterface;
use WebSocket\Client;
use WebSocket\ConnectionException;

class WebSocketConnection implements PubSubConnectionInterface
{
    public function __construct(private Client $client)
    {
        $this->client->setTimeout(-1);
    }

    public function publish(string $channel, string $data): void
    {
        $this->client->text(json_encode([
            'channel' => $channel,
            'event' => 'publish',
            'message' => $data
        ]));
    }

    public function subscribe(array $channels, Closure $callback): void
    {
        $this->client->text(json_encode([
            'channels' => $channels,
            'event' => 'subscribe',
            'message' => 'Subscription'
        ]));

        while (true) {
            try {
                $message = $this->client->receive();
                $data = json_decode($message, true);
                if (is_array($data)) {
                    $callback($data['message'], $data['channel']);
                }
            } catch (ConnectionException $e) {
                $this->client->close();
            }
        }
    }
}
