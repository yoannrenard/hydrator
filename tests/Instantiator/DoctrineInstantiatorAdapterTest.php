<?php

namespace YoannRenard\Hydrator\Instantiator;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Doctrine\Instantiator\InstantiatorInterface as DoctrineInstantiatorInterface;
use YoannRenard\Hydrator\Dummy\Person;
use YoannRenard\PHPUnitAnnotation\TestCase\AnnotationTestCase;

class DoctrineInstantiatorAdapterTest extends AnnotationTestCase
{
    /**
     * @var DoctrineInstantiatorAdapter
     *
     * @factory("YoannRenard\Hydrator\Instantiator\DoctrineInstantiatorAdapter", params={"doctrineInstantiatorMock"})
     */
    protected $doctrineInstantiatorAdapter;

    /**
     * @var DoctrineInstantiatorInterface
     *
     * @mock Doctrine\Instantiator\InstantiatorInterface
     */
    protected $doctrineInstantiatorMock;

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InvalidArgumentInstantiatorException
     * @expectedExceptionMessage exception message
     */
    public function it_catches_and_throws_an_invalid_argument_exception()
    {
        $this->doctrineInstantiatorMock->instantiate('toto')->willThrow(new InvalidArgumentException('exception message', 500));

        $this->doctrineInstantiatorAdapter->instantiate('toto');
    }

    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\UnexpectedValueInstantiatorException
     * @expectedExceptionMessage exception message
     */
    public function it_catches_and_throws_an_unexpected_value_exception()
    {
        $this->doctrineInstantiatorMock->instantiate('toto')->willThrow(new UnexpectedValueException('exception message', 500));

        $this->doctrineInstantiatorAdapter->instantiate('toto');
    }

    /**
     * @test
     */
    public function it_instantiate_a_dummy_person()
    {
        $personMock = $this->prophesize(Person::class);
        $this->doctrineInstantiatorMock->instantiate(Person::class)->willReturn($personMock->reveal());

        $this->assertInstanceOf(Person::class, $this->doctrineInstantiatorAdapter->instantiate(Person::class));
    }
}
