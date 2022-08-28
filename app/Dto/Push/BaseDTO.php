<?php

namespace MitinSany\PushCommon\App\Dto\Push;

abstract class BaseDTO
{
    abstract public function toArray() : array;

    public function serialize() : ?string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}