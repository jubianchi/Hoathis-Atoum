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
 * \Hoa\Math\Sampler\Random
 */
-> import('Math.Sampler.Random')

/**
 * \Hoa\Praspel\Iterator\Sampler
 */
-> import('Praspel.Iterator.Sampler');

}

namespace Hoathis\Atoum\Test\Provider {

/**
 * Class \Hoathis\Atoum\Test\Provider\Praspel.
 *
 * Praspel provider.
 *
 * @author     Julien Bianchi <contact@jubianchi.fr>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin.
 * @license    New BSD License
 */

abstract class Generator {

	protected $_sampler;

	public function generate ( ) {
		if($this->_sampler === null) {
			$this->_sampler = new \Hoa\Praspel\Iterator\Sampler(
				\Hoa\Praspel::interprete('@requires x:' . $this . ';')
					->getClause('requires'),
				\Hoa\Praspel\Iterator\Sampler::KEY_AS_VARIABLE_POSITION
			);

			$this->_sampler->rewind();
		}

		$value = $this->_sampler->next();
		return $value[0];
	}

	public abstract function __toString();
}

}
