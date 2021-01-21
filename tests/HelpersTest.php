<?php

/*
 * This file is part of the Laravel Paga package.
 *
 * (c) Henry Ugochukwu <phalconvee@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalconvee\Paga\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    protected $paga;
    protected $mock;

    public function setUp(): void
    {
        $this->paga = m::mock('Phalconvee\Paga\Paga');
        $this->mock = m::mock('GuzzleHttp\Client');
    }

    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_returns_instance_of_paga()
    {
        $this->assertInstanceOf("Phalconvee\Paga\Paga", $this->paga);
    }
}
