<?php

namespace MitinSany\PushCommon\App\Services;

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
