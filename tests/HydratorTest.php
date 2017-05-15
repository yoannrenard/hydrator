<?php

namespace YoannRenard\Hydrator;

class Person
{
    private $lastName;
    private $firstName;

    /**
     * Person constructor.
     *
     * @param $lastName
     */
    public function __construct($lastName)
    {
        $this->lastName = $lastName;
    }


    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }
}

class HydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Hydrator */
    protected $hydrator;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->hydrator = new Hydrator([
            Person::class => [
                'lastName'  => 'lastName',
                'firstName' => 'firstName',
            ],
        ]);
    }

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InvalidMappingException
     * @expectedExceptionMessage The `toto` class isn't mapped.
     */
    public function it_throws_an_exception_as_the_class_mapped_does_not_match()
    {
        $this->hydrator->hydrate('toto', [
            'lastName'  => 'Parker',
            'firstName' => 'Peter',
        ]);
    }

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InvalidMappingException
     * @expectedExceptionMessage The `nom` property isn't mapped in `YoannRenard\Hydrator\Person`.
     */
    public function it_throws_an_exception_as_the_property_mapped_does_not_match()
    {
        $this->hydrator->hydrate(Person::class, [
            'nom'    => 'Parker',
            'prenom' => 'Peter',
        ]);
    }

    /**
     * @test
     */
    public function it_hydrates_properly_a_person()
    {
        /** @var Person $peterParker */
        $peterParker = $this->hydrator->hydrate(Person::class, [
            'lastName'  => 'Parker',
            'firstName' => 'Peter',
        ]);

        $this->assertEquals('Parker', $peterParker->getLastName());
        $this->assertEquals('Peter', $peterParker->getFirstName());
    }
}
