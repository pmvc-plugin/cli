<?php
namespace PMVC\PlugIn\cmd;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\cmd';

class cmd extends \PMVC\PlugIn
{
    public function onMapRequest()
    {
        $controller = \PMVC\getC();
        $argv = $GLOBALS['argv'];
        if (empty($argv[1])) {
            return null;
        }
        $param1 = explode(':',$argv[1]);
        if (!empty($param1[0])) {
            $controller->setApp($param1[0]);
        }
        if (!empty($param1[1])) {
            $controller->setAppAction($param1[1]);
        } else {
            $controller->setAppAction($param1[0]);
        }
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
    }

}
