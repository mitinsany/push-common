<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Dto\Push;

abstract class BaseDTO
{
    public function serialize() : ?string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function getFields(): array
    {
        return static::FIELDS;
    }

    public function toArray(): ?array
    {
        $result = null;
        foreach($this->getFields() as $field) {
            $result[$field] = $this->$field;
        }
        return $result;
    }
}