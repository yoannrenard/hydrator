<?php

namespace YoannRenard\Hydrator\Instantiator;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Doctrine\Instantiator\InstantiatorInterface as DoctrineInstantiatorInterface;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use YoannRenard\Hydrator\Exception\InstantiatorException;
use YoannRenard\Hydrator\Exception\InvalidArgumentInstantiatorException;
use YoannRenard\Hydrator\Exception\UnexpectedValueInstantiatorException;

class DoctrineInstantiatorAdapter implements InstantiatorInterface
{
    /** @var DoctrineInstantiatorInterface */
    protected $doctrineInstantiator;

    /**
     * @param DoctrineInstantiatorInterface $doctrineInstantiator
     */
    public function __construct(DoctrineInstantiatorInterface $doctrineInstantiator)
    {
        $this->doctrineInstantiator = $doctrineInstantiator;
    }

    /**
     * @inheritdoc
     */
    public function instantiate($className)
    {
        try {
            return $this->doctrineInstantiator->instantiate($className);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentInstantiatorException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueInstantiatorException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (ExceptionInterface $e) {
            throw new InstantiatorException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
