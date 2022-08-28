<?php

namespace MitinSany\PushCommon\App\Factories;

use MitinSany\PushCommon\App\Dto\Push\PushMessageDTO;

class BaseFactory
{
    protected const FIELDS = [];

    public static function createFromArray(array $data): PushMessageDTO
    {
        $pushMessageDTO = new PushMessageDTO();
        foreach (static::FIELDS as $key) {
            if (!empty($data[$key])) {
                $pushMessageDTO->$key = $data[$key];
            }
        }
        return $pushMessageDTO;
    }
}