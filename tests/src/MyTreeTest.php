<?php

namespace PMVC\PlugIn\cli;

use PMVC;
use PHPUnit_Framework_TestCase;
use ReflectionProperty;


class MyTreeTest extends PHPUnit_Framework_TestCase
{
   private $_plug = 'cli';
   public function testSimpleCallTree()
   {
        $p = PMVC\plug($this->_plug);
        
        ob_start();
        $p->tree(['a', 'b', 'c']);
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertStringContainsString('a',$output);
        $this->assertStringContainsString('b',$output);
        $this->assertStringContainsString('c',$output);
   }

   public function testStdErrCall()
   {
        $p = PMVC\plug($this->_plug);
        $oTree = MyTree::getInstance();
        $streamProp = new ReflectionProperty($oTree, 'errStream');
        $stream = fopen('php://memory', 'rw');
        $streamProp->setAccessible(true);
        $streamProp->setValue($oTree, $stream);
        $p->tree(['a', 'b', 'c'], null, true);
        fseek($stream, 0);
        $output = stream_get_contents($stream);
        $this->assertStringContainsString('a',$output);
        $this->assertStringContainsString('b',$output);
        $this->assertStringContainsString('c',$output);
   }
}
