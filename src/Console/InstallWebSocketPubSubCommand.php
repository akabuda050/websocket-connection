<?php

namespace JsonBaby\WebSocketPubSub\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallWebSocketPubSubCommand extends Command
{
    protected $signature = 'websocket-pubsub:install';

    protected $description = 'Install the WebSocketPubSub';

    public function handle(): void
    {
        $this->info('Installing WebSocketPubSub...');

        $this->info('Publishing configuration...');

        if (! $this->configExists('websocket-pubsub.php')) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration(true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }

        $this->info('Installed WebSocketPubSub');
    }

    private function configExists(string $fileName): bool
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration(bool $forcePublish = false): void
    {
        $params = [
            '--tag' => "websocket-pubsub-config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

       $this->call('vendor:publish', $params);
    }
}