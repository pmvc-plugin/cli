<?php
namespace PMVC\PlugIn\cmd;

\PMVC\l(__DIR__.'/src/class.cmd.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cmd';

class cmd extends \PMVC\PlugIn
{
    private $cmd;
    private $args;

    public function init()
    {
        $this->cmd = new \cmd();
        $argv = $GLOBALS['argv'];
        if(!empty($argv)){
            $this->args = $this->commands($argv);
        }
    }

    public function get($k=null,$default=null)
    {
        return \PMVC\get($this->args,$k,$default);
    }

    public function args($args=array())
    {
        // return array('commands'=>array(),'input'=>array());
        return $this->cmd->arguments($args);
    }

    public function commands($args=array())
    {
        $arr=$this->cmd->arguments($args);
        return $arr['commands'];
    }
}
