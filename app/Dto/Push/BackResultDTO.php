<?php

namespace MitinSany\PushCommon\App\Dto\Push;


class BackResultDTO extends BaseDTO
{
    public const FIELDS = [
        'push_message_guid',
        'response',
    ];

    public ?int $push_message_guid = null;
    public ?array $response = null;
}
