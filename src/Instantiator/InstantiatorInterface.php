<?php

namespace YoannRenard\Hydrator\Instantiator;

use YoannRenard\Hydrator\Exception\InstantiatorException;

interface InstantiatorInterface
{
    /**
     * @param string $className
     *
     * @return object
     *
     * @throws InstantiatorException
     */
    public function instantiate($className);
}
