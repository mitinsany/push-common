<?php

namespace MitinSany\PushCommon\App\Dto\Push;

class PushMessageDTO extends BaseDTO
{
    public const FIELDS = [
        'push_message_id',
        'token_provider',
        'push_token',
        'bundle_str',
        'title',
        'body',
        'options',
    ];

    public ?int $push_message_id = null;
    public ?string $token_provider = null;
    public ?string $push_token = null;
    public ?string $bundle_str = null;
    public ?string $title = null;
    public ?string $body = null;
    public ?array $options = null;
}
