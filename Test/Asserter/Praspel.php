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
 * \Hoa\Praspel\Model\Specification
 */
-> import('Praspel.Model.Specification');

}

namespace Hoathis\Atoum\Test\Asserter {

/**
 * Class \Hoathis\Atoum\Test\Asserter.
 *
 * Praspel asserter. A simple wrapper around \Hoa\Praspel\Model\Specification.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Praspel {

    /**
     * Specification.
     *
     * @var \Hoa\Praspel\Model\Specification object
     */
    protected $_specification = null;



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
     * @return  \Hoathis\Atoum\Test\Asserter\Praspel
     */
    public function reset ( ) {

        $this->_specification = new \Hoa\Praspel\Model\Specification();

        return $this;
    }

    /**
     * Compute the test verdict.
     *
     * @access  public
     * @return  void
     */
    public function verdict ( ) {


    }
}

}
