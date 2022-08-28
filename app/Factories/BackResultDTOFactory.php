<?php

namespace MitinSany\PushCommon\App\Factories;

/**
 * @method BackResultDTOFactory createFromArray()
 */
class BackResultDTOFactory extends BaseFactory
{
    protected const FIELDS = [
        'push_message_id',
        'result',
    ];
}