<?php

namespace YoannRenard\Hydrator;

interface HydratorInterface
{
    /**
     * @param string $className
     * @param array  $data
     *
     * @throws \YoannRenard\Hydrator\Exception\InvalidMappingException
     *
     * @return array
     */
    public function hydrate($className, array $data = array());
}
