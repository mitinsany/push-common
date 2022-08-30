<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Dto\Push;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @BackResultDTO
 *
 * @property-read string message_uuid
 * @property-read string result
 */
class BackResultDTO extends DataTransferObject
{
    public string $message_uuid;
    public string $result;
}
