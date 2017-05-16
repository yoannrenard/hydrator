<?php

namespace YoannRenard\Hydrator\Dummy;

class Person
{
    /** @var string */
    private $lastName;

    /** @var string */
    private $firstName;

    /**
     * @param string $lastName
     * @param string $firstName
     */
    public function __construct($lastName, $firstName)
    {
        $this->lastName  = $lastName;
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
}
