<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Factories;

use MitinSany\PushCommon\Dto\Push\PushMessageDTO;

/**
 * @method static createFromArray(array $data): PushMessageDTO
 */
class PushMessageDTOFactory extends BaseFactory
{
    protected const TARGET_CLASS = PushMessageDTO::class;
}
