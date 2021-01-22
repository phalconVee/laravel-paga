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

use Orchestra\Testbench\TestCase;
use Phalconvee\Paga\Facades\Paga;
use Phalconvee\Paga\PagaServiceProvider;

class PagaTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PagaServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Paga' => Paga::class,
        ];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
