<?php

namespace MitinSany\PushCommon\Services;

use MitinSany\PushCommon\Enums\SourceTransportTypesEnum;
use MitinSany\PushCommon\Enums\OwnTransportTypesEnum;
use MitinSany\PushCommon\Exceptions\UnknownServiceException;

class TransportMappingService
{
    private const SOURCE_OWN_MAPPING = [
        SourceTransportTypesEnum::GCM => OwnTransportTypesEnum::FNS,
        SourceTransportTypesEnum::APNS => OwnTransportTypesEnum::ANS,
        SourceTransportTypesEnum::HMS => OwnTransportTypesEnum::HNS,
    ];

    /**
     * @param string $transport
     * @return string
     * @throws UnknownServiceException
     */
    public static function convertSourceToOwn(string $transport): string
    {
        if(!array_key_exists($transport, static::SOURCE_OWN_MAPPING)) {
            throw new UnknownServiceException($transport);
        }
        return static::SOURCE_OWN_MAPPING[$transport];
    }

    /**
     * @param string $transport
     * @return string
     * @throws UnknownServiceException
     */
    public static function convertOwnToSource(string $transport): string
    {
        $ownSourceMapping = array_flip(static::SOURCE_OWN_MAPPING);
        if(!array_key_exists($transport, $ownSourceMapping)) {
            throw new UnknownServiceException($transport);
        }
        return $ownSourceMapping[$transport];
    }
}