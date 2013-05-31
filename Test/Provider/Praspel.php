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
 * \Hoa\Realdom
 */
-> import('Realdom.~')

/**
 * \Hoa\Praspel
 */
-> import('Praspel.~');

from('Hoathis')

-> import('Atoum.Test.Provider.Generators.*');

}

namespace Hoathis\Atoum\Test\Provider {

/**
 * Class \Hoathis\Atoum\Test\Provider\Praspel.
 *
 * Praspel provider.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

class Praspel {

	/**
	 * Assertion manager.
	 *
	 * @var \mageekguy\atoum\test\assertion\manager object
	 */
	protected $_assertionManager = null;

    /**
     * Constructor.
     *
     * @access  public
     * @return  void
     */
    public function __construct ( ) {

        \Hoa\Realdom::setDefaultSampler(new \Hoa\Math\Sampler\Random());

		$this->setAssertionManager();

        return;
    }

	public function __get($property)
	{
		return $this->_assertionManager->invoke($property);
	}

	public function __call($method, array $arguments)
	{
		return $this->_assertionManager->invoke($method, $arguments);
	}

	public function setAssertionManager ( \mageekguy\atoum\test\assertion\manager $assertionManager = null ) {

		$old  = $this->_assertionManager;
		$self = $this;

		$this->_assertionManager = $assertionManager ?: new \mageekguy\atoum\test\assertion\manager();

		$this->_assertionManager
			->setDefaultHandler($defaultHandler = function ( $event, $args ) {

				$classname = __NAMESPACE__ . '\\Generators\\' . $event;

				if(class_exists($classname)) {
					$reflection = new \ReflectionClass($classname);
					return $reflection->newInstanceArgs($args);
				}
			})
			->setHandler('boundinteger', $boundIntegerHandler = function ( ) use ( $self ) {

				return call_user_func_array(array($self, 'BoundInteger'), func_get_args());
			})
			->setHandler('boundint', $boundIntegerHandler)
			->setHandler('smallinteger', $smallIntegerHandler = function ( ) use ( $self ) {

				return call_user_func_array(array($self, 'SmallInteger'), func_get_args());
			})
			->setHandler('smallint', $smallIntegerHandler)
			->setHandler('integer', $intHandler = function ( ) use ( $self ) {

				return call_user_func_array(array($self, 'Integer'), func_get_args());
			})
			->setHandler('int', $intHandler)
			->setHandler('boolean', $boolHandler = function ( ) use ( $self ) {

				return call_user_func_array(array($self, 'Boolean'), func_get_args());
			})
			->setHandler('bool', $boolHandler)
			->setHandler('Array', $arrayHandler = function ( ) use ( $defaultHandler ) {

				return $defaultHandler('PhpArray', func_get_args());
			})
			->setHandler('array', $arrayHandler)
			->setHandler('arr', $arrayHandler)
			->setHandler('string', $stringHandler = function ( ) use ( $self ) {

				return call_user_func_array(array($self, 'String'), func_get_args());
			})
			->setHandler('str', $stringHandler)
			->setHandler('expression', $exprHandler = function ( ) use ( $self ) {
				return call_user_func_array(array($self, 'Expression'), func_get_args());
			})
			->setHandler('expr', $exprHandler)
			->setHandler('provide', function ( \Hoathis\Atoum\Test\Provider\Generator $generator, $size = 10 ) {
				$data = array();

				while(sizeof($data) < $size) {
					$data[] = $generator->generate();
				}

			return $data;
			});


		return $old;
	}
}

}
