<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Services;

use GuzzleHttp\ClientInterface;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;
use Nwilging\LaravelDiscordBot\Support\Component;
use Nwilging\LaravelDiscordBot\Support\Embed;
use Nwilging\LaravelDiscordBot\Support\Traits\DiscordApiService as IsApiService;

class DiscordApiService implements DiscordApiServiceContract
{
    use IsApiService;

    public function __construct(string $token, string $apiUrl, ClientInterface $httpClient)
    {
        $this->token = $token;
        $this->apiUrl = $apiUrl;
        $this->httpClient = $httpClient;
    }

    public function sendTextMessage(string $channelId, string $message, array $options = []): array
    {
        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages', $channelId),
            array_merge($this->buildMessageOptions($options), [
                'content' => $message,
            ]),
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendRichTextMessage(string $channelId, array $embeds, array $components = [], array $options = []): array
    {
        $response = $this->makeRequest(
            'POST',
            sprintf('channels/%s/messages', $channelId),
            array_merge($this->buildMessageOptions($options), [
                'embeds' => $embeds,
                'components' => $components,
            ]),
        );

        return json_decode($response->getBody()->getContents(), true);
    }


    public function addRoleToMember(string $guildId, string $userId, string $roleId, string $reason = null): void
    {
        $options = [];
        if ($reason) {
            $options['headers'] = [
                'X-Audit-Log-Reason' => $reason,
            ];
        }

        $this->makeRequest(
            'PUT',
            sprintf('guilds/%s/members/%s/roles/%s', $guildId, $userId, $roleId),
            $options
        );
    }

    protected function buildMessageOptions(array $options): array
    {
        return [];
    }
}
