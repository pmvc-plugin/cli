<?php
namespace PMVC\PlugIn\cli;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\line';

class line
{
    function __invoke($color="%U%W", $sign='-', $num=80)
    {
        $cli = \PMVC\plug($this->caller[\PMVC\NAME]);
        $cli->dump(str_repeat($sign, $num), $color);
    }
}
