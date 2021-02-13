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

namespace Phalcon\Test\Integration\Forms\Element\File;

use IntegrationTester;

/**
 * Class GetFiltersCest
 */
class GetFiltersCest
{
    /**
     * Tests Phalcon\Forms\Element\File :: getFilters()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function formsElementFileGetFilters(IntegrationTester $I)
    {
        $I->wantToTest('Forms\Element\File - getFilters()');
        $I->skipTest('Need implementation');
    }
}
