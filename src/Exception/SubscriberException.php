<?php

namespace Jtl\Connector\Core\Exception;

/**
 * Class SubscriberException
 * @package Jtl\Connector\Core\Exception
 */
class SubscriberException extends \Exception
{
    public const INVALID_MODEL_TYPE = 10;

    /**
     * @param string $expectedModelClass
     * @param string $givenModelClass
     * @return SubscriberException
     */
    public static function invalidModelTypeInArray(
        string $expectedModelClass,
        string $givenModelClass
    ): SubscriberException {
        return new self(\sprintf(
            "Invalid model type in array. Expected %s object but %s given",
            $expectedModelClass,
            $givenModelClass
        ), self::INVALID_MODEL_TYPE);
    }
}
