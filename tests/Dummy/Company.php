<?php

namespace YoannRenard\Hydrator\Dummy;

class Company
{
    /** @var Person[] */
    private $persons;

    /** @var Address */
    private $address;

    /**
     * @param Address  $address
     * @param Person[] $persons
     */
    public function __construct(Address $address, array $persons = [])
    {
        $this->address = $address;
        $this->persons = $persons;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Person[]
     */
    public function getPersons()
    {
        return $this->persons;
    }
}
