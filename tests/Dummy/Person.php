<?php

namespace YoannRenard\Hydrator\Dummy;

class Person
{
    /** @var string */
    private $lastName;

    /** @var string */
    private $firstName;

    /** @var \DateTimeImmutable */
    private $birthdate;

    /**
     * @param string             $lastName
     * @param string             $firstName
     * @param \DateTimeImmutable $birthdate
     */
    public function __construct($lastName, $firstName, \DateTimeImmutable $birthdate = null)
    {
        $this->lastName  = $lastName;
        $this->firstName = $firstName;
        $this->birthdate = $birthdate;
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

    /**
     * @return \DateTimeImmutable
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}
