<?php

namespace MitinSany\PushCommon\App\Factories;

use MitinSany\PushCommon\App\Dto\Push\PushMessageDTO;

/**
 * @method static createFromArray(array $data): PushMessageDTO
 */
class PushMessageDTOFactory extends BaseFactory
{
    protected const TARGET_CLASS = PushMessageDTO::class;
}
