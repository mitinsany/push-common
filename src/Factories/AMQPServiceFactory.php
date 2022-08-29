<?php

declare(strict_types=1);

namespace MitinSany\PushCommon\Factories;

use MitinSany\PushCommon\Services\AMQPService;

class AMQPServiceFactory
{
    private static AMQPService $singleton;

    public function singleton(): AMQPService
    {
        if (empty(self::$singleton)) {
            self::$singleton = new AMQPService();
        }
        return self::$singleton;
    }
}
