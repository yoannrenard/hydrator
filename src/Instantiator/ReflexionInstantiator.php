<?php

namespace YoannRenard\Hydrator\Instantiator;

use YoannRenard\Hydrator\Exception\InstantiatorException;

class ReflexionInstantiator implements InstantiatorInterface
{
    /**
     * @inheritdoc
     */
    public function instantiate($className)
    {
        try {
            return (new \ReflectionClass($className))->newInstanceWithoutConstructor();
        } catch (\Exception $e) {
            throw new InstantiatorException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\Error $e) {
            throw new InstantiatorException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
