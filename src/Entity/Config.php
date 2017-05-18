<?php

namespace YoannRenard\Hydrator\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Config
{
    /** @var ArrayCollection<Element> */
    private $elementList;

    /**
     * @param ArrayCollection $elementList
     */
    public function __construct(ArrayCollection $elementList)
    {
        $this->elementList = $elementList;
    }

    /**
     * @param Element $element
     */
    public function addElementList(Element $element)
    {
        if (!$this->elementList->contains($element)) {
            $this->elementList->add($element);
        }
    }

    /**
     * @return ArrayCollection<Element>
     */
    public function getElementList()
    {
        return $this->elementList;
    }

    /**
     * @param $key
     *
     * @return Element|null
     */
    public function getElement($key)
    {
        return $this->elementList->get($key);
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function has($className)
    {
       return $this->get($className) instanceof Element;
    }

    /**
     * @param string $className
     *
     * @return Element|null
     */
    public function get($className)
    {
        /** @var Element $element */
        foreach ($this->elementList as $element) {
            if ($className == $element->getClassName()) {
                return $element;
            }
        }

        return null;
    }
}
