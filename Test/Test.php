<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2013, Ivan Enderlin. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoathis\Atoum\Test {

/**
 * Class \Hoathis\Atoum\Test.
 *
 * Extend \mageekguy\atoum\test.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Test extends \mageekguy\atoum\test {

    /**
     * Praspel asserter.
     *
     * @var \Hoathis\Atoum\Test\Asserter\Praspel object
     */
    protected $_praspelAsserter = null;



    /**
     *
     */
    public function __construct ( \mageekguy\atoum\adapter               $adapter                = null,
                                  \mageekguy\atoum\annotations\extractor $annotationExtractor    = null,
                                  \mageekguy\atoum\asserter\generator    $asserterGenerator      = null,
                                  \mageekguy\atoum\assertion\manager     $assertionManager       = null,
                                  \Closure                               $reflectionClassFactory = null ) {

        $this->setPraspelAsserter();

        parent::_construct(
            $adapter,
            $annotationExtractor,
            $asserterGenerator,
            $assertionManager,
            $reflectionClassFactory
        );

        return;
    }

    /**
     * Set Praspel asserter.
     *
     * @access  public
     * @param   \Hoathis\Atoum\Test\Asserter\Praspel  $praspelAsserter    Praspel asserter.
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function setPraspelAsserter ( Asserter\Praspel $praspelAsserter = null ) {

        $old                    = $this->_praspelAsserter;
        $this->_praspelAsserter = $praspelAsserter ?: new Asserter\Praspel();

        return $old;
    }

    /**
     * Get Praspel asserter.
     *
     * @access  public
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function getPraspelAsserter ( ) {

        return $this->_praspelAsserter;
    }

    /**
     * Reset Praspel asserter before each test execution.
     * This method _must_ be called.
     *
     * @access  public
     * @param   string  $testMethod    Test method name.
     * @return  mixed
     */
    public function beforeTestMethod ( $testMethod ) {

        $out = parent::beforeTestMethod($testMethod);
        $this->getPraspelAsserter()->reset();

        return $out;
    }

    /**
     * Set assertion manager.
     *
     * @access  public
     * @param   \mageekguy\atoum\test\assertion\manager  $assertionManager    Assertion manager.
     * @return  mixed
     */
    public function setAssertionManager ( \mageekguy\atoum\test\assertion\manager $assertionManager = null ) {

        $out             = parent::setAssertionManager($assertionManager);
        $praspelAsserter = $this->getPraspelAsserter();

        $this->assertionManager
             ->setHandler('praspel', function ( ) use ( $praspelAsserter ) {

                 return $praspelAsserter;
             }
             ->setHandler('requires', function ( ) use ( $praspelAsserter ) {

                 return $praspelAsserter->requires;
             })
             ->setHandler('ensures', function ( ) use ( $praspelAsserter ) {

                 return $praspelAsserter->ensures;
             });

        return $out;
    }
}

}
