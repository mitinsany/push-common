<?php

namespace MitinSany\PushCommon\App\Factories;

use MitinSany\PushCommon\App\Dto\Push\PushMessageDTO;

class BaseFactory
{
    protected const FIELDS = [];

    public static function createFromArray(array $data): BaseFactory
    {
        $dto = new static();
        foreach (static::FIELDS as $key) {
            if (!empty($data[$key])) {
                $dto->$key = $data[$key];
            }
        }
        return $dto;
    }
}