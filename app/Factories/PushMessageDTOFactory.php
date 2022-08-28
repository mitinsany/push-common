<?php

namespace MitinSany\PushCommon\App\Factories;

use MitinSany\PushCommon\App\Dto\Push\PushMessageDTO;

class PushMessageDTOFactory
{
    public static function createFromArray(array $data): PushMessageDTO
    {
        $pushMessageDTO = new PushMessageDTO();
        foreach ([
                     'push_message_id',
                     'token_provider',
                     'push_token',
                     'bundle_str',
                     'title',
                     'body',
                     'options',
                 ] as $key) {
            if (!empty($data[$key])) {
                $pushMessageDTO->$key = $data[$key];
            }
        }
        return $pushMessageDTO;
    }
}
