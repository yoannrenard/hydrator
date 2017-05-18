<?php

namespace YoannRenard\Hydrator\Entity;

use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    /**
     * @test
     * @expectedException \YoannRenard\Hydrator\Exception\InvalidArgumentException
     * @expectedExceptionMessage The `int` property type is not supported. Use `scalar` or a class that can be instantiated
     */
    public function it_throws_an_exception_as_the_type_is_not_valid()
    {
        new Property('toto', 'int');
    }

    /**
     * @test
     */
    public function it_instantiate_a_property_from_scalar_type()
    {
        $this->assertInstanceOf(Property::class, new Property('toto', 'scalar'));
    }

    /**
     * @test
     */
    public function it_instantiate_a_property_from_default_type()
    {
        $this->assertInstanceOf(Property::class, new Property('toto'));
    }

    /**
     * @test
     */
    public function it_instantiate_a_property_from_class_type()
    {
        $this->assertInstanceOf(Property::class, new Property('toto'), \DateTimeImmutable::class);
    }
}
