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

namespace {

from('Hoa')

/**
 * \Hoa\Praspel
 */
-> import('Praspel.~')

/**
 * \Hoa\Praspel\Model\Specification
 */
-> import('Praspel.Model.Specification');

}

namespace Hoathis\Atoum\Test\Asserter {

use mageekguy\atoum\asserter;

    /**
 * Class \Hoathis\Atoum\Test\Asserter.
 *
 * Praspel asserter. A simple wrapper around \Hoa\Praspel\Model\Specification.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Praspel extends asserter {

    /**
     * Runtime Assertion Checker.
     *
     * @var \Hoa\Praspel object
     */
    protected $_rac           = null;

    /**
     * Specification.
     *
     * @var \Hoa\Praspel\Model\Specification object
     */
    protected $_specification = null;

    /**
     * Method name.
     *
     * @var \Hoathis\Atoum\Test\Asserter\Praspel mixed
     */
    protected $_method        = null;



    /**
     * Alias to \Hoa\Praspel\Model\Specification::getClause().
     *
     * @access  public
     * @return  string  $name    Clause name.
     * @return  \Hoa\Praspel\Model\Clause
     */
    public function __get ( $name ) {

        return $this->_specification->getClause($name);
    }

    /**
     * Reset the asserter, i.e. create a new fresh specification.
     *
     * @access  public
     * @param   string                               Callable.
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function setWith ( $method ) {

        $this->_specification = new \Hoa\Praspel\Model\Specification();
        $this->_method      = $method;

        return $this;
    }

    /**
     * Set method.
     *
     * @access  public
     * @param   string  $method    Method.
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function setMethod ( $method ) {

        $this->_method = $method;

        return $this;
    }

    /**
     * Get method.
     *
     * @access  public
     * @return  string
     */
    public function getMethod ( ) {

        return $this->_method;
    }

    /**
     * Compute the test verdict.
     *
     * @access  public
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function verdict ( $sut ) {
        $this->_rac = new \Hoa\Praspel(
            $this->_specification,
            xcallable($sut, $this->_method)
        );

        if($this->_rac->evaluate() === false) {
            $this->fail('Verdict was false');
        }

        return $this->pass();
    }

    /**
     * Get Runtime Assertion Checker.
     *
     * @access  public
     * @return  \Hoa\Praspel
     */
    public function getRAC ( ) {

        return $this->_rac;
    }

    /**
     * Get specification.
     *
     * @access  public
     * @return  \Hoa\Praspel\Model\Specification
     */
    public function getSpecification ( ) {

        return $this->_specification;
    }
}

}
