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

from('Hoathis')

/**
 * \Hoathis\Atoum\Praspel\Visitor\Compiler
 */
-> import('Atoum.Praspel.Visitor.Compiler');


from('Hoa')

/**
 * \Hoa\Praspel
 */
-> import('Praspel.~')

/**
 * \Hoa\Praspel\Iterator\Coverage
 */
-> import('Praspel.Iterator.Coverage.~');

}

namespace Hoathis\Atoum\Praspel {

/**
 * Class \Hoathis\Atoum\Praspel\Generator.
 *
 * Generate tests based on a Praspel-annotated class.
 *
 * @author     Ivan Enderlin <ivan.enderlin@hoa-project.net>
 * @author     Julien Bianchi <julien.bianchi@hoa-project.net>
 * @copyright  Copyright © 2007-2013 Ivan Enderlin, Julien Bianchi.
 * @license    New BSD License
 */

class Generator  {

    /**
     * Generate tests based on a Praspel-annotated class.
     *
     * @access  public
     * @param   \ReflectionClass  $class     Annotated class.
     * @return  string
     */
    public static function generate ( \ReflectionClass $class ) {

        $className = '\\' . $class->getName();
        $compiler  = new Visitor\Compiler();
        $out       = '<?php' . "\n\n" .
                     'namespace {' . "\n\n" .
                     'require_once \'' . $class->getFileName() . '\';' . "\n\n" .
                     '}' . "\n\n" .
                     'namespace tests\units' .
                     (true === $class->inNamespace()
                         ? '\\' . $class->getNamespace
                         : '') . ' {' . "\n\n" .
                     'class ' . $class->getName() .
                     ' extends \Hoathis\Atoum\Test {' . "\n";
        $_         = '    ';
        $__        = $_ . $_;
        $___       = $_ . $_ . $_;
        $____      = $_ . $_ . $_ . $_;

        foreach($class->getMethods() as $method) {

            $methodName = $method->getName();

            $specification = \Hoa\Praspel::interprete(
                $contract = \Hoa\Praspel::extractFromComment($method->getDocComment())
            );

            $coverage = new \Hoa\Praspel\Iterator\Coverage($specification);
            $coverage->setCriteria($coverage::CRITERIA_NORMAL);

            foreach($coverage as $i => $path) {

                $out .= "\n" .
                        $_ . '/**' . "\n" .
                        $_ . ' * The specification is:' . "\n" .
                        $_ . ' * ' . "\n" .
                        $_ . ' * ' .
                        str_replace("\n", "\n" . $_ . ' * ', $contract) . "\n" .
                        $_ . ' */' . "\n" .
                        $_ . 'public function test ' . $methodName .
                        ' n°' . ($i + 1) . ' ( ) {' . "\n\n" .
                        $__ . '$this';

                foreach($path['pre'] as $i => $clause)
                    $out .= str_replace(
                        "\n",
                        "\n" . $___,
                        $compiler->visit($clause, $methodName, $i)
                    );

                foreach($path['post'] as $clause)
                    $out .= str_replace(
                        "\n",
                        "\n" . $___,
                        $compiler->visit($clause, $methodName)
                    );

                $out .= "\n" . $___ . '->then';

                $out .= "\n" .
                        $____ . '->praspel->verdict(new ' . $className . '());' . "\n\n" .
                        $__ . 'return;' . "\n" .
                        $_ . '}' . "\n";
            }
        }

        $out .= '}' . "\n\n" . '}' . "\n";

        return $out;
    }
}

}
