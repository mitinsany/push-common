<?php

namespace MitinSany\PushCommon\App\Dto\Push;

class BackResultDTO extends BaseDTO
{
    public ?int $push_message_id = null;
    public ?array $response = null;

    public function toArray(): array
    {
        return [
            'push_message_id' => $this->push_message_id,
            'response' => $this->response,
        ];
    }
}
