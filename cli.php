<?php
namespace PMVC\PlugIn\cli;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cli';
\PMVC\l(__DIR__.'/src/Color2.php');

const PLUGIN='cli';

class cli
    extends \PMVC\PlugIn
    implements \PMVC\RouterInterface
{
    private $_color;
    public function onMapRequest()
    {
        $controller = \PMVC\getC();
        $opts = $this->getopt();
        if (empty($opts[1])) {
            return;
        }else{
            $app = explode(':',$opts[1]);
        }
        $request = $controller->getRequest();
        foreach($opts as $k=>$v){
            if (!is_numeric($k)) {
                $request[$k] = $v; 
            }
        }
        if (isset($app[0])) {
            $controller->setApp($app[0]);
        }
        if (isset($app[1])) {
            $controller->setAppAction($app[1]);
        }
    }

    public function init()
    {
        \PMVC\call_plugin(
            'dispatcher',
            'attach',
            array(
                $this,
                \PMVC\Event\MAP_REQUEST
            )
        );
        \PMVC\call_plugin(
            'dispatcher',
            'attach',
            array(
                $this,
                'SetConfig'
            )
        );
        $this->_color = new Console_Color2();
    }

    public function color($color,$text)
    {
        if (is_array($text) || is_object($text)) {
            $text = var_export($text,true);
        }
        $text = $this->_color->escape($text);
        return $this->_color->convert($color.$text.'%n');
    }

    public function dump($text,$color="%m")
    {
        echo $this->color($color,$text)."\n";
    }

    public function buildCommand($path, $params)
    {
    }

    public function processHeader($headers)
    {
    }
    
    public function go($path)
    {
    }
}
