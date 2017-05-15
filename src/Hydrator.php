<?php

namespace YoannRenard\Hydrator;

use YoannRenard\Hydrator\Exception\InvalidMappingException;

class Hydrator implements HydratorInterface
{
    /** @var array */
    protected $mapping;

    /**
     * @param array $mapping
     */
    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($className, array $data = array())
    {
        if (!isset($this->mapping[$className])) {
            throw InvalidMappingException::invalidMappedClass($className);
        }

        $ref = new \ReflectionClass($className);
        $object = $ref->newInstanceWithoutConstructor();

        $changePropertyClosure = function ($property, $value) {
            $this->$property = $value;
        };
        $doChangePropertyClosure = $changePropertyClosure->bindTo($object, get_class($object));

        foreach ($data as $key => $value) {
            if (!isset($this->mapping[$className][$key])) {
                throw InvalidMappingException::invalidMappedProperty($key, $className);
            }

            $doChangePropertyClosure($key, $value);
        }

        return $object;
    }
}
