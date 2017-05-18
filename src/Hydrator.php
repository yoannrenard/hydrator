<?php

namespace YoannRenard\Hydrator;

use YoannRenard\Hydrator\Entity\Config;
use YoannRenard\Hydrator\Exception\InvalidMappingException;
use YoannRenard\Hydrator\Instantiator\InstantiatorInterface;

class Hydrator implements HydratorInterface
{
    /** @var InstantiatorInterface */
    protected $instantiator;

    /** @var array */
    protected $mapping;

    /** @var Config */
    protected $config;

    /**
     * @param InstantiatorInterface $instantiator
     * @param Config                $config
     */
    public function __construct(InstantiatorInterface $instantiator, Config $config)
    {
        $this->instantiator = $instantiator;
        $this->config       = $config;
    }

    /**
     * @return \Closure
     */
    public function getSetPropertyClosure()
    {
        return function ($property, $value) {
            $this->$property = $value;
        };
    }

    /**
     * @return \Closure
     */
    public function getAddPropertyClosure()
    {
        return function ($property, $value) {
            $this->{$property}[] = $value;
        };
    }

    /**
     * @inheritdoc
     */
    public function hydrate($className, array $data = array())
    {
        $classConfig = $this->config->get($className);

        if (null === $classConfig) {
            throw InvalidMappingException::invalidMappedClass($className);
        }

        $object = $this->instantiator->instantiate($className);

        $setPropertyClosure = $this->getSetPropertyClosure()->bindTo($object, get_class($object));
        $addPropertyClosure = $this->getAddPropertyClosure()->bindTo($object, get_class($object));

        foreach ($data as $propertyName => $value) {
            $propertyConfig = $classConfig->getProperty($propertyName);
            if (null === $propertyConfig) {
                throw InvalidMappingException::invalidMappedProperty($propertyName, $className);
            }

            if ('scalar' == $propertyConfig->getType()) {
                // String
                $setPropertyClosure($propertyName, $value);
            } elseif (class_exists($propertyConfig->getType())) {
                // Object
                if ($propertyConfig->isCollection()) {
                    // Object collection
                    foreach ($value as $data) {
                        $addPropertyClosure($propertyName, $this->hydrate($propertyConfig->getType(), $data));
                    }
                } else {
                    // Single object
                    if ($propertyConfig->useConstructor()) {
                        $propertyClass = $propertyConfig->getType();

                        if (!is_array($value)) {
                            // Single value
                            $setPropertyClosure($propertyName, new $propertyClass($value));
                        } else {
                            // Array value
                            $setPropertyClosure($propertyName, new $propertyClass(...$value));
                        }
                    } else {
                        $setPropertyClosure($propertyName, $this->hydrate($propertyConfig->getType(), $value));
                    }
                }
            }
        }

        return $object;
    }
}
