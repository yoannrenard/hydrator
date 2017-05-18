<?php

namespace YoannRenard\Hydrator\Exception;

class InvalidMappingException extends \RuntimeException implements HydratorInterface
{
    /**
     * @param string $className
     *
     * @return InvalidMappingException
     */
    public static function invalidMappedClass($className)
    {
        return new self(sprintf('The `%s` class isn\'t mapped.', $className));
    }

    /**
     * @param string $property
     * @param string $className
     *
     * @return InvalidMappingException
     */
    public static function invalidMappedProperty($property, $className)
    {
        return new self(sprintf('The `%s` property isn\'t mapped in `%s`.', $property, $className));
    }
}
