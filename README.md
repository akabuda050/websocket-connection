# Very short description of the package

This package provides websocket connection example for [EventBridge package](https://packagist.org/packages/jsonbaby/event-bridge "EventBridge package").

In order to get this work you also need to install [Simple PubSub WebSocket Server package](https://www.npmjs.com/package/simple-pubsub-websocket-server "Simple PubSub WebSocket Server package") or build your own.

## Installation

`composer require jsonbaby/websocket-connection`

## Usage

- Install and run [Simple PubSub WebSocket Server package](https://www.npmjs.com/package/simple-pubsub-websocket-server "Simple PubSub WebSocket Server package")

- Check the readme of how to use [EventBridge package](https://packagist.org/packages/jsonbaby/event-bridge "EventBridge package")

- Change `pubsub.provider` in your `config/event-bridge.php` in your apps to looks like
  ```
  'pubsub' =>  [
        'entity' => JsonBaby\EventBridge\Entities\EventPubSub::class,
        'provider' => JsonBaby\WebsocketConnection\WebSocketConnection::class
    ]
  ```

Thats all! [EventBridge package](https://packagist.org/packages/jsonbaby/event-bridge "EventBridge package") will handle the rest:p
