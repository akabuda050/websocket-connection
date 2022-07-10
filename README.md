# Very short description of the package

This package provides websocket publish/subscribe functionality for [EventBridge](https://packagist.org/packages/jsonbaby/event-bridge "EventBridge").

In order to get this work you also need to install [Simple PubSub WebSocket Server package](https://www.npmjs.com/package/simple-pubsub-websocket-server "Simple PubSub WebSocket Server package") or build your own:p.

## Installation

`composer require jsonbaby/websocket-pubsub`

`php artisan websocket-pubsub:install`

## Usage

- Install and run [Simple PubSub WebSocket Server package](https://www.npmjs.com/package/simple-pubsub-websocket-server "Simple PubSub WebSocket Server package")

- Change `websocket_uri` and add `options` if you want in `config/websocket-pubsub.php`. See [Websocket Client and Server for PHP package](https://github.com/Textalk/websocket-php/blob/master/docs/Client.md "Websocket Client and Server for PHP") for options reference.
