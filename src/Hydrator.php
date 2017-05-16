<?php

namespace YoannRenard\Hydrator;

use YoannRenard\Hydrator\Exception\InvalidMappingException;
use YoannRenard\Hydrator\Instantiator\InstantiatorInterface;

class Hydrator implements HydratorInterface
{
    /** @var InstantiatorInterface */
    protected $instantiator;

    /** @var array */
    protected $mapping;

    /**
     * @param InstantiatorInterface $instantiator
     * @param array                 $mapping
     */
    public function __construct(InstantiatorInterface $instantiator, array $mapping = [])
    {
        $this->instantiator = $instantiator;
        $this->mapping      = $mapping;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($className, array $data = array())
    {
        if (!isset($this->mapping[$className])) {
            throw InvalidMappingException::invalidMappedClass($className);
        }

        $object = $this->instantiator->instantiate($className);

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
