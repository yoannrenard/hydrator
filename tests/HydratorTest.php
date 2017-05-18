<?php

namespace YoannRenard\Hydrator;

use Doctrine\Common\Collections\ArrayCollection;
use YoannRenard\Hydrator\Dummy;
use YoannRenard\Hydrator\Entity\Config;
use YoannRenard\Hydrator\Entity\Element;
use YoannRenard\Hydrator\Entity\Property;
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

        $config = new Config(new ArrayCollection([
            // Company
            new Element(Dummy\Company::class, new ArrayCollection([
                new Property('address', Dummy\Address::class),
                new Property('persons', Dummy\Person::class, $isCollection = true),
            ])),
            // Address
            new Element(Dummy\Address::class, new ArrayCollection([
                new Property('address'),
            ])),
            // Person
            new Element(Dummy\Person::class, new ArrayCollection([
                new Property('lastName'),
                new Property('firstName'),
                new Property('birthdate', \DateTimeImmutable::class, $isCollection = false, $useConstructor = true),
            ])),
        ]));

        $this->hydrator = new Hydrator($this->instantiator, $config);
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
    public function it_hydrates_properly_a_company_with_one_address()
    {
        /** @var Dummy\Company $spiderMan */
        $spiderMan = $this->hydrator->hydrate(Dummy\Company::class, [
            'address' => [
                'address' => '1 rue des Alouettes',
            ],
        ]);

        $this->assertInstanceOf(Dummy\Company::class, $spiderMan);
        $this->assertEquals('1 rue des Alouettes', $spiderMan->getAddress()->getAddress());
    }

    /**
     * @test
     */
    public function it_hydrates_properly_a_company_with_persons()
    {
        /** @var Dummy\Company $spiderMan */
        $spiderMan = $this->hydrator->hydrate(Dummy\Company::class, [
            'persons' => [
                [
                    'lastName'  => 'Parker',
                    'firstName' => 'Peter',
                    'birthdate' => '2017-05-18',
                ],
                [
                    'lastName'  => 'Goblin',
                    'firstName' => 'Green',
                    'birthdate' => ['2017-05-18', new \DateTimeZone('Europe/Paris')]
                ],
                [
                    'lastName'  => 'Cat',
                    'firstName' => 'Black',
                ],
                [
                ],
            ],
        ]);

        $this->assertInstanceOf(Dummy\Company::class, $spiderMan);
        $this->assertEquals(
            [
                new Dummy\Person('Parker', 'Peter', new \DateTimeImmutable('2017-05-18')),
                new Dummy\Person('Goblin', 'Green', new \DateTimeImmutable('2017-05-18', new \DateTimeZone('Europe/Paris'))),
                new Dummy\Person('Cat', 'Black'),
                new Dummy\Person(null, null),
            ],
            $spiderMan->getPersons()
        );
    }
}
