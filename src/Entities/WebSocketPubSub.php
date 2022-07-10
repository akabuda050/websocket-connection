<?php

namespace JsonBaby\WebSocketPubSub\Entities;

use JsonBaby\PubSubBase\Interfaces\ChannelHandler;
use JsonBaby\PubSubBase\Interfaces\ClientInterface;
use JsonBaby\PubSubBase\Interfaces\PubSubInterface;

class WebSocketPubSub implements PubSubInterface
{
    public function __construct(private ClientInterface $client)
    {
        $this->client->setTimeout(-1);
    }

    public function publish(string $channel, string $data): void
    {
        $this->client->send(json_encode([
            'channel' => $channel,
            'event' => 'publish',
            'message' => $data
        ]));
    }

    public function subscribe(array $channels, ChannelHandler $channelHandler): void
    {

        $this->client->connect($channels);

        while (true) {
            try {
                $message = $this->client->receive();
                $data = json_decode($message, true);
                if (is_array($data)) {
                    $channelHandler->handle($data['channel'], $data['message']);
                }
            } catch (\Exception $e) {
                $this->client->close();
            }
        }
    }
}
