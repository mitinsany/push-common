<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Dto\Push;

/**
 * @property string $message_uuid
 * @property array $result
 */
class BackResultDTO extends BaseDTO
{
    public const FIELDS = [
        'message_uuid',
        'result',
    ];

    public ?string $message_uuid = null;
    public ?array $result = null;
}
