<?php

namespace YoannRenard\Hydrator\Dummy;

class Address
{
    /** @var string */
    private $address;

    /**
     * @param string $address
     */
    public function __construct($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
