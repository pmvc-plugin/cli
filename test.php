<?php
PMVC\Load::mvc();
PMVC\addPlugInFolder('../');
class CmdTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'cmd';
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }
}
