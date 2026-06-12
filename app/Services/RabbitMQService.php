<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RabbitMQService
{
    /**
     * Publish an event to RabbitMQ, with fallback to HTTP bridge if AMQP fails.
     *
     * @param string $routingKey
     * @param array $data
     * @param string|null $bearerToken
     * @return bool
     */
    public function publish($routingKey, array $data, $bearerToken = null)
    {
        if (!defined('SOCKET_EAGAIN')) {
            define('SOCKET_EAGAIN', 11);
        }
        if (!defined('SOCKET_EWOULDBLOCK')) {
            define('SOCKET_EWOULDBLOCK', 11);
        }
        if (!defined('SOCKET_EINPROGRESS')) {
            define('SOCKET_EINPROGRESS', 115);
        }
        if (!defined('SOCKET_EINTR')) {
            define('SOCKET_EINTR', 4);
        }

        $published = false;

        try {
            $host = env('RABBITMQ_HOST', 'iae-sso.virtualfri.id');
            $port = env('RABBITMQ_PORT', 5672);
            $user = env('RABBITMQ_USER', 'guest');
            $pass = env('RABBITMQ_PASSWORD', 'guest');

            $connection = new AMQPStreamConnection($host, $port, $user, $pass, '/', false, 'AMQPLAIN', null, 'en_US', 2.0, 2.0);
            $channel = $connection->channel();

            $exchange = 'iae.central.exchange';
            $channel->exchange_declare($exchange, 'topic', false, true, false);

            $payload = [
                'event' => 'component.received',
                'team_id' => env('IAE_TEAM_ID', 'TEAM-03'),
                'data' => $data,
                'timestamp' => now()->toIso8601String()
            ];

            $msg = new AMQPMessage(json_encode($payload), [
                'content_type' => 'application/json',
                'delivery_mode' => 2 // persistent
            ]);

            $channel->basic_publish($msg, $exchange, $routingKey);

            $channel->close();
            $connection->close();

            Log::info("Successfully published message to RabbitMQ via AMQP on key: $routingKey");
            $published = true;
        } catch (\Exception $e) {
            Log::warning("Direct AMQP publishing failed (connection issue): " . $e->getMessage() . ". Trying HTTP bridge fallback...");
        }

        if (!$published && $bearerToken) {
            try {
                $url = 'https://iae-sso.virtualfri.id/api/v1/messages/publish';
                $payload = [
                    'routing_key' => $routingKey,
                    'message' => [
                        'event' => 'component.received',
                        'team_id' => env('IAE_TEAM_ID', 'TEAM-03'),
                        'data' => $data
                    ]
                ];

                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $bearerToken,
                        'Content-Type' => 'application/json'
                    ])
                    ->post($url, $payload);

                if ($response->successful()) {
                    Log::info("Successfully published message to RabbitMQ via HTTP bridge");
                    $published = true;
                } else {
                    Log::error("HTTP Bridge publishing fallback failed. Status: " . $response->status() . " Body: " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("HTTP Bridge publishing fallback failed: " . $e->getMessage());
            }
        }

        return $published;
    }
}
