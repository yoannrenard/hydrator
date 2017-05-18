<?php

namespace YoannRenard\Hydrator\Entity;

use YoannRenard\Hydrator\Exception\InvalidArgumentException;

class Property
{
    const TYPE_DEFAULT = 'scalar';

    /** @var string */
    protected $name;

    /** @var string */
    protected $type;

    /** @var bool */
    protected $isCollection;

    /** @var bool */
    protected $useConstructor;

    /**
     * @param string $name
     * @param string $type
     * @param bool   $isCollection
     * @param bool   $useConstructor
     */
    public function __construct($name, $type = self::TYPE_DEFAULT, $isCollection = false, $useConstructor = false)
    {
        if (self::TYPE_DEFAULT !== $type && !class_exists($type)) {
            throw InvalidArgumentException::invalidPropertyType($type);
        }

        $this->name           = $name;
        $this->type           = $type;
        $this->isCollection   = $isCollection;
        $this->useConstructor = $useConstructor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isCollection()
    {
        return $this->isCollection;
    }

    /**
     * @return bool
     */
    public function useConstructor()
    {
        return $this->useConstructor;
    }
}
