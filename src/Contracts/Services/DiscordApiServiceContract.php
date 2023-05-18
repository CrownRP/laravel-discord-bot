<?php
declare(strict_types=1);

namespace Nwilging\LaravelDiscordBot\Contracts\Services;

interface DiscordApiServiceContract
{
    public function sendTextMessage(string $channelId, string $message, array $options = []): array;

    /**
     * @param string $channelId
     * @param array[] $embeds
     * @param array[] $components
     * @param array $options
     * @return array
     */
    public function sendRichTextMessage(string $channelId, array $embeds, array $components = [], array $options = []): array;
}
