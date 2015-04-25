<?php
namespace PMVC\PlugIns;

\PMVC\l(__DIR__.'/class.cmd.php');

${_INIT_CONFIG}[_CLASS] = 'PMVC\PlugIns\PMVC_PLUGIN_cmd';

class PMVC_PLUGIN_cmd extends \PMVC\PLUGIN
{
    private $cmd;
    function init(){
        $this->cmd = new \cmd(); 
    }

    function args($args){
        // return array('commands'=>array(),'input'=>array());
        return $this->cmd->arguments($args);
    }

    function commands($args){
        $arr=$this->cmd->arguments($args);
        return $arr['commands'];
    }
}
?>
