<?php

namespace JsonBaby\WebSocketPubSub\Entities;

use JsonBaby\PubSubBase\Interfaces\ClientInterface;
use WebSocket\Client;

class WebSocketClient implements ClientInterface
{
    public function __construct(private Client $client)
    {
    }

    public function setTimeout(int $timeOut): void
    {
        $this->client->setTimeout($timeOut);
    }

    public function connect(array $channels): void
    {
        $this->send(json_encode([
            'channels' => $channels,
            'event' => 'subscribe',
            'message' => 'Subscription'
        ]));
    }

    public function close(): void
    {
        $this->client->close();
    }

    public function send(string $message): void
    {
        $this->client->text($message);
    }

    public function receive(): string
    {
        return $this->client->receive();
    }
}
