<?php

namespace MitinSany\PushCommon\Dto\Push;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @PushMessageDTO
 *
 * @property-read string message_uuid;
 * @property-read string token_provider;
 * @property-read string push_token;
 * @property-read string bundle_str;
 * @property-read string title;
 * @property-read string body;
 * @property-read array options;
 */
class PushMessageDTO extends DataTransferObject
{
    public string $message_uuid;
    public string $token_provider;
    public string $push_token;
    public string $bundle_str;
    public string $title;
    public string $body;
    public array $options;
}