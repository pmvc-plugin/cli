<?php
namespace PMVC\PlugIn\cmd;

\PMVC\l(__DIR__.'/class.cmd.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cmd';

class cmd extends \PMVC\PlugIn
{
    private $cmd;
    public function init()
    {
        $this->cmd = new \cmd();
    }

    public function args($args)
    {
        // return array('commands'=>array(),'input'=>array());
        return $this->cmd->arguments($args);
    }

    public function commands($args)
    {
        $arr=$this->cmd->arguments($args);
        return $arr['commands'];
    }
}
