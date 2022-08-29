<?php

namespace MitinSany\PushCommon\App\Dto\Push;


class BackResultDTO extends BaseDTO
{
    public const FIELDS = [
        'message_uuid',
        'response',
    ];

    public ?int $message_uuid = null;
    public ?array $response = null;
}
