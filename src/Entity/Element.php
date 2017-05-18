<?php

namespace YoannRenard\Hydrator\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Element
{
    /** @var string */
    protected $className;

    /** @var ArrayCollection<Property> */
    protected $propertyList;

    /**
     * @param string          $className
     * @param ArrayCollection $propertyList
     */
    public function __construct($className, ArrayCollection $propertyList)
    {
        $this->className    = $className;
        $this->propertyList = $propertyList;
    }

    /**
     * @param Property $property
     */
    public function addPropertyList(Property $property)
    {
        if (!$this->propertyList->contains($property)) {
            $this->propertyList->add($property);
        }
    }

    /**
     * @return ArrayCollection<Property>
     */
    public function getPropertyList()
    {
        return $this->propertyList;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    public function hasProperty($propertyName)
    {
        return $this->getProperty($propertyName) instanceof Property;
    }

    /**
     * @param string $propertyName
     *
     * @return Property|null
     */
    public function getProperty($propertyName)
    {
        /** @var Property $property */
        foreach ($this->propertyList as $property) {
            if ($propertyName == $property->getName()) {
                return $property;
            }
        }

        return null;
    }
}
