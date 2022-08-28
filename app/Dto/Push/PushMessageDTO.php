<?php

namespace MitinSany\PushCommon\App\Dto\Push;

class PushMessageDTO
{
    public ?int $push_message_id = null;
    public ?string $token_provider = null;
    public ?string $push_token = null;
    public ?string $bundle_str = null;
    public ?string $title = null;
    public ?string $body = null;
    public ?array $options = null;

    public function toArray() : array
    {
        return [
            'push_message_id' => $this->push_message_id,
            'token_provider' => $this->token_provider,
            'push_token' => $this->push_token,
            'bundle_str' => $this->bundle_str,
            'title' => $this->title,
            'body' => $this->body,
            'options' => $this->options,
        ];
    }

    public function serialize() : ?string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
