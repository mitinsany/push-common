<?php

namespace MitinSany\PushCommon\App\Dto\Push;

/**
 * @property string message_uuid
 * @property string token_provider
 * @property string push_token
 * @property string bundle_str
 * @property string title
 * @property string body
 * @property array options
 */
class PushMessageDTO extends BaseDTO
{
    public const FIELDS = [
        'message_uuid',
        'token_provider',
        'push_token',
        'bundle_str',
        'title',
        'body',
        'options',
    ];

    public ?string $message_uuid = null;
    public ?string $token_provider = null;
    public ?string $push_token = null;
    public ?string $bundle_str = null;
    public ?string $title = null;
    public ?string $body = null;
    public ?array $options = null;
}
