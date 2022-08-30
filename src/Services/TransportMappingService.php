<?php

namespace MitinSany\PushCommon\Services;

use MitinSany\PushCommon\Enums\TransportTypes\SelfTransportTypesEnum;
use MitinSany\PushCommon\Enums\TransportTypes\SourceTransportTypesEnum;
use MitinSany\PushCommon\Exceptions\UnknownServiceException;

class TransportMappingService
{
    private const SOURCE_OWN_MAPPING = [
        SourceTransportTypesEnum::GCM => SelfTransportTypesEnum::FNS,
        SourceTransportTypesEnum::APNS => SelfTransportTypesEnum::ANS,
        SourceTransportTypesEnum::HMS => SelfTransportTypesEnum::HNS,
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
