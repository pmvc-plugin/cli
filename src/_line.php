<?php
namespace PMVC\PlugIn\cli;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\line';

class line
{
    function __invoke($color="%U%W")
    {
        $cli = \PMVC\plug(PLUGIN);
        $cli->dump('------------------------------------------------', $color);
    }
}
