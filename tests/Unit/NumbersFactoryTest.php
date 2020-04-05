<?php

namespace Tests\Unit;

use App\Entity\Numbers;
use App\Services\NumbersFactory;
use PHPUnit\Framework\TestCase;

class NumbersFactoryTest extends TestCase
{

    /**
     * @var NumbersFactory
     */
    private $numbersFactory;

    public function setUp()
    {
        $this->numbersFactory = new NumbersFactory();
    }

    public function test_create_new_numbers()
    {
        $numbers = $this->numbersFactory->createNewNumbers();
        $this->assertInstanceOf(Numbers::class, $numbers);
    }
}