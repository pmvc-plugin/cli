<?php
PMVC\Load::plug();
PMVC\addPlugInFolder('../');
class CmdTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'cmd';
    function testHello()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testParseRoot()
    {
        $plug = \PMVC\plug($this->_plug);
        $root = '/';
        $argv = array(
            'xxx.php',
            '--path',
            $root 
        );
        $result = $plug->commands($argv); 
        $this->assertEquals($root,$result['path']);
    }

    function testParseMultiItem()
    {
        $plug = \PMVC\plug($this->_plug);
        $argv = array(
            'xxx.php',
            'aaa',
            'bbb',
            '--abc=yyy',
            '--def',
            'zzz'
        );
        $expected = array(
            'input'=> array(
                'aaa',
                'bbb'
            ),
            'commands'=>array(
                'abc'=>'yyy',
                'def'=>'zzz'
            )
        );
        $result = $plug->args($argv); 
        $this->assertEquals($expected, $result);
    }
}
