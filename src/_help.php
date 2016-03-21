<?php
namespace PMVC\PlugIn\cli;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\help';

class help
{
    private $_plug;
    function __construct($plug)
    {
        $this->_plug = $plug;
    }

    function __invoke()
    {

    }
}
