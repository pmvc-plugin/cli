<?php

namespace PMVC\PlugIn\cli;

use PMVC;
use PMVC\TestCase;
use PMVC\MappingBuilder;

class CliTest extends TestCase
{
    private $_plug = 'cli';

   protected function pmvc_setup()
   {
        PMVC\unplug($this->_plug);
        PMVC\unplug('controller');
   }

    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->haveString($this->_plug, $output);
    }

    public function testLine()
    {
        ob_start();
        $cli = \PMVC\plug('cli');
        $cli->line();
        $output = trim(ob_get_contents());
        ob_end_clean();
        $expected =
            '[4m[1;37m--------------------------------------------------------------------------------[0m';
        $this->assertEquals($expected, $output);
    }

    public function testStderr()
    {
        $expected = 'foo';
        $p = PMVC\plug($this->_plug);
        $stream = fopen('php://memory', 'rw');
        $p->stderr($expected, $stream);
        fseek($stream, 0);
        $actual = stream_get_contents($stream);
        $this->assertEquals($expected, $actual);
    }

    public function testMapRequest()
    {
        $controller = \PMVC\plug('controller');
        $b = new MappingBuilder();
        $b->addAction('fakeAction');
        $controller->addMapping($b);
        $p = PMVC\plug($this->_plug);
        $p->getOpt(['/bin/fakeCli', 'fakeApp:fakeAction', '--fake-opts']);
        $p->onMapRequest();
        $this->assertEquals('fakeapp', $controller->getApp());
        $this->assertEquals('fakeAction', $controller->getAppAction());
    }
}
