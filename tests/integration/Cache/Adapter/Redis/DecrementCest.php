<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Integration\Cache\Adapter\Redis;

use Phalcon\Support\Exception as HelperException;
use Phalcon\Cache\Adapter\Redis;
use Phalcon\Storage\Exception as CacheException;
use Phalcon\Storage\SerializerFactory;
use Phalcon\Support\HelperFactory;
use Phalcon\Tests\Fixtures\Traits\RedisTrait;
use IntegrationTester;

use function getOptionsRedis;

class DecrementCest
{
    use RedisTrait;

    /**
     * Tests Phalcon\Cache\Adapter\Redis :: decrement()
     *
     * @param IntegrationTester $I
     *
     * @throws CacheException
     * @throws HelperException
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function storageAdapterRedisDecrement(IntegrationTester $I)
    {
        $I->wantToTest('Cache\Adapter\Redis - decrement()');

        $I->skipTest('Check this');

        $helper     = new HelperFactory();
        $serializer = new SerializerFactory();
        $adapter    = new Redis($helper, $serializer, getOptionsRedis());

        $key    = uniqid();
        $actual = $adapter->set($key, 100);
        $I->assertTrue($actual);

        $expected = 99;
        $actual   = $adapter->decrement($key);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        $expected = 90;
        $actual   = $adapter->decrement($key, 9);
        $I->assertEquals($expected, $actual);

        $actual = $adapter->get($key);
        $I->assertEquals($expected, $actual);

        /**
         * unknown key
         */
        $key    = 'unknown';
        $actual = $adapter->decrement($key, 9);
        $I->assertFalse($actual);
    }
}
