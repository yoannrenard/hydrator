<?php

namespace YoannRenard\Hydrator\Instantiator;

use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;
use YoannRenard\Hydrator\Dummy\Person;

class ReflexionInstantiatorTest extends AnnotationTestCase
{
    /**
     * @var ReflexionInstantiator
     *
     * @factory("YoannRenard\Hydrator\Instantiator\ReflexionInstantiator")
     */
    protected $reflexionInstantiator;

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InstantiatorException
     * @expectedExceptionMessage Class toto does not exist
     */
    public function it_throws_an_exception_as_the_class_to_instantiate_does_not_exist()
    {
        $this->reflexionInstantiator->instantiate('toto');
    }

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InstantiatorException
     * @expectedExceptionMessage Class toto does not exist
     */
    public function it_throws_a_random_exception()
    {
        $this->reflexionInstantiator->instantiate('toto');
    }

    /**
     * @test
     */
    public function it_instantiate_a_person()
    {
        $this->assertInstanceOf(Person::class, $this->reflexionInstantiator->instantiate(Person::class));
    }
}
