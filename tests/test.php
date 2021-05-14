<?php

namespace PMVC\PlugIn\cli;

use PMVC;
use PMVC\TestCase;

class CliTest extends TestCase
{
    private $_plug = 'cli';
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug,$output);
    }

    public function testLine()
    {
        ob_start();
        $cli = \PMVC\plug('cli');
        $cli->line();
        $output = trim(ob_get_contents());
        ob_end_clean();
        $expected = "[4m[1;37m--------------------------------------------------------------------------------[0m";
        $this->assertEquals($expected, $output);
    }
}
