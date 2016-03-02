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
        $argv = $GLOBALS['argv'];
        if (empty($argv[1])) {
            return null;
        }
        $param1 = str_replace('--','',$argv[1]);
        $param2 = getopt('',[$param1.':']);
        $controller->setApp($param1);
        $controller->setAppAction($param2[$param1]);
    }

    public function onSetConfig()
    {
        if (!\PMVC\plug('dispatcher')->isSetOption(_SCOPE)) {
            return;
        }
        $scope = \PMVC\getOption(_SCOPE);
        if (!is_array($scope->scope)) {
            return;
        }
        $params = getopt('',$scope->scope);
        $controller = \PMVC\getC();
        $request = $controller->getRequest();
        \PMVC\set($request, $params);
        $scope->scope = null;
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
