<?php

namespace MitinSany\PushCommon\Factories;

use MitinSany\PushCommon\Dto\Push\BackResultDTO;

/**
 * @method static createFromArray(array $data): BackResultDTO
 */
class BackResultDTOFactory extends BaseFactory
{
    protected const TARGET_CLASS = BackResultDTO::class;
}
