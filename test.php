<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');
class HelloTest extends PHPUnit_Framework_TestCase
{
    function testHello()
    {
        ob_start();
        print_r(PMVC\plug('cmd'));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains('cmd',$output);
    }
}
