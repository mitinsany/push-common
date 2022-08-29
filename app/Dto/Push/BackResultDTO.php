<?php

namespace MitinSany\PushCommon\App\Dto\Push;


class BackResultDTO extends BaseDTO
{
    public const FIELDS = [
        'push_message_id',
        'response',
    ];

    public ?int $push_message_id = null;
    public ?array $response = null;
}
