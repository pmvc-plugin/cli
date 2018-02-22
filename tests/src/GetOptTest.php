<?php

namespace PMVC\PlugIn\cli;

use PMVC;
use PHPUnit_Framework_TestCase;


class GetOptTest extends PHPUnit_Framework_TestCase
{
   private $_plug = 'cli';

   public function setup()
   {
        PMVC\unplug($this->_plug);
   }

   public function testShortBool()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '-a'
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>true
        ];
        $this->assertEquals($expected, $actual);
   }

   public function testShortWithValue()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '-a',
            'abc'
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>'abc'
        ];
        $this->assertEquals($expected, $actual);
   }

   public function testShortWithConcatValue()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '-aabc',
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>'abc'
        ];
        $this->assertEquals($expected, $actual);
   }

   public function testLongBool()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '--a'
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>true
        ];
        $this->assertEquals($expected, $actual);
   }

   public function testLongWithValue()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '--a',
            'abc'
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>'abc'
        ];
        $this->assertEquals($expected, $actual);
   }

   public function testLongWithEqual()
   {
        $p = PMVC\plug($this->_plug);
        $arr = [
            '--a=abc',
        ];
        $actual = $p->getopt($arr); 
        $expected = [
            'a'=>'abc'
        ];
        $this->assertEquals($expected, $actual);
   }

   /**
    * @dataProvider multiProvider
    */
   public function testMulti($feed, $expected)
   {
        $p = PMVC\plug($this->_plug);
        $actual = $p->getopt($feed); 
        $this->assertEquals($expected, $actual);
   }

   public function multiProvider()
   {
        return [
           [
                [
                    '-a',
                    'abc',
                    '-b',
                    '-cddd',
                    '--e=fff'
                ],
                [
                    'a'=>'abc',
                    'b'=>true,
                    'c'=>'ddd',
                    'e'=>'fff'
                ]
           ],
           [
                [
                    '/bin/pmvc',
                    'stock:sync_price',
                    '--ids',
                    '0050'
                ],
                [
                    '/bin/pmvc',
                    'stock:sync_price',
                    'ids'=>'0050'
                ],
           ]
        ];
   }
}
