<?php

namespace YoannRenard\Hydrator\Exception;

class InvalidArgumentException extends \InvalidArgumentException implements HydratorInterface
{
    /**
     * @param string $type
     *
     * @return InvalidArgumentException
     */
    public static function invalidPropertyType($type)
    {
        return new self(sprintf(
            'The `%s` property type is not supported. Use `scalar` or a class that can be instantiated',
            $type
        ));
    }
}
