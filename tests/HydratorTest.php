<?php

namespace YoannRenard\Hydrator;

use YoannRenard\Hydrator\Dummy;
use YoannRenard\Hydrator\Instantiator\InstantiatorInterface;
use YoannRenard\Hydrator\Instantiator\ReflexionInstantiator;

class HydratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Hydrator */
    protected $hydrator;

    /** @var InstantiatorInterface */
    protected $instantiator;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        // Unfortunately a mock does not work here
        $this->instantiator = new ReflexionInstantiator();

        $this->hydrator = new Hydrator($this->instantiator, [
            Dummy\Company::class => [
                'persons' => [
                    Dummy\Person::class => [
                        'lastName'  => 'lastName',
                        'firstName' => 'firstName',
                    ],
                ]
            ],
            Dummy\Person::class => [
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
     * @expectedExceptionMessage The `nom` property isn't mapped in `YoannRenard\Hydrator\Dummy\Person`.
     */
    public function it_throws_an_exception_as_the_property_mapped_does_not_match()
    {
        $this->hydrator->hydrate(Dummy\Person::class, [
            'nom'    => 'Parker',
            'prenom' => 'Peter',
        ]);
    }

    /**
     * @test
     */
    public function it_hydrates_properly_a_person()
    {
        /** @var Dummy\Person $peterParker */
        $peterParker = $this->hydrator->hydrate(Dummy\Person::class, [
            'lastName'  => 'Parker',
            'firstName' => 'Peter',
        ]);

        $this->assertEquals('Parker', $peterParker->getLastName());
        $this->assertEquals('Peter', $peterParker->getFirstName());
    }

    /**
     * @test
     */
    public function it_hydrates_properly_a_company_with_persons()
    {
        /** @var Dummy\Company $spiderMan */
        $spiderMan = $this->hydrator->hydrate(Dummy\Company::class, [
            'persons' => [
                $this->hydrator->hydrate(Dummy\Person::class, [
                    'lastName'  => 'Parker',
                    'firstName' => 'Peter',
                ]),
                $this->hydrator->hydrate(Dummy\Person::class, [
                    'lastName'  => 'Goblin',
                    'firstName' => 'Green',
                ]),
                $this->hydrator->hydrate(Dummy\Person::class, [
                    'lastName'  => 'Cat',
                    'firstName' => 'Black',
                ]),
            ],
        ]);

        $this->assertEquals(
            new Dummy\Company([
                new Dummy\Person('Parker', 'Peter'),
                new Dummy\Person('Goblin', 'Green'),
                new Dummy\Person('Cat', 'Black'),
            ]),
            $spiderMan
        );
    }
}
