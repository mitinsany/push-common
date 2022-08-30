<?php

namespace MitinSany\PushCommon\Dto\Push;

use Spatie\DataTransferObject\DataTransferObject;

class TestPushMessageDTO extends DataTransferObject
{
    public string $message_uuid;
    public string $token_provider;
    public string $push_token;
    public string $bundle_str;
    public string $title;
    public string $body;
    public array $options;
}