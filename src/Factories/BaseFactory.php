<?php

namespace MitinSany\PushCommon\Factories;

use MitinSany\PushCommon\Dto\Push\BaseDTO;

class BaseFactory
{
    public static function createFromArray(array $data): BaseDTO
    {
        $targetClass = static::TARGET_CLASS;
        /** @var BaseDTO $dto */
        $dto = new $targetClass();
        foreach ($dto->getFields() as $key) {
            if (!empty($data[$key])) {
                $dto->$key = $data[$key];
            }
        }
        return $dto;
    }
}