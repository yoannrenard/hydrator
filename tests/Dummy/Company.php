<?php

namespace YoannRenard\Hydrator\Dummy;

class Company
{
    /** @var Person[] */
    private $persons;

    /**
     * Company constructor.
     *
     * @param Person[] $persons
     */
    public function __construct(array $persons)
    {
        $this->persons = $persons;
    }

    /**
     * @return Person[]
     */
    public function getPersons()
    {
        return $this->persons;
    }
}
