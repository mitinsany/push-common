<?php

namespace MitinSany\PushCommon\App\Factories;

use MitinSany\PushCommon\App\Dto\Push\PushMessageDTO;

class PushMessageDTOFactory extends BaseFactory
{
    protected const FIELDS = [
        'push_message_id',
        'token_provider',
        'push_token',
        'bundle_str',
        'title',
        'body',
        'options',
    ];
}
