<?php

namespace MitinSany\PushCommon\Dto\Push;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @PushMessageDto
 *
 * @property-read string message_uuid;
 * @property-read string transport_type;
 * @property-read string push_token;
 * @property-read string bundle_str;
 * @property-read string title;
 * @property-read string description;
 * @property-read array data;
 */
class PushMessageDto extends DataTransferObject
{
    public string $message_uuid;
    public string $transport_type;
    public string $push_token;
    public string $bundle_str;
    public ?string $title = null;
    public ?string $description = null;
    public array $data;
}
