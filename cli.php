<?php

namespace PMVC\PlugIn\cli;

use PMVC\NamespaceAdapter;
use PMVC\PlugIn;
use PMVC\RouterInterface;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\cli';

\PMVC\l(__DIR__ . '/src/ConsoleColor2');
\PMVC\initPlugIn(['controller' => null], true);

class cli extends PlugIn implements RouterInterface
{
    private $_color;

    public function getOptApp()
    {
        $opts = $this->getopt();
        if (empty($opts[1])) {
            $appsFolder = \PMVC\lastSlash(
                \PMVC\plug('controller')->getAppsFolder()
            );
            $pwd = getcwd();
            $start = strpos($pwd, $appsFolder);
            if (0 === $start) {
                $sApp = explode('/', substr($pwd, strlen($appsFolder)));
                if (!empty($sApp[0])) {
                    $app = [$sApp[0]];
                }
            }
            if (empty($app)) {
                return;
            }
        } else {
            $app = explode(':', $opts[1]);
        }
        return compact('opts', 'app');
    }

    public function onMapRequest()
    {
        extract(\PMVC\assign(['opts', 'app'], $this->getOptApp()));
        $controller = \PMVC\plug('controller');
        $request = $controller->getRequest();
        foreach ($opts as $k => $v) {
            if (!is_numeric($k)) {
                $request[$k] = $v;
            } elseif ($k > 1) {
                $request[] = $v;
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
        \PMVC\callPlugin('dispatcher', 'attach', [
            $this,
            \PMVC\Event\MAP_REQUEST,
        ]);
        $this->_color = new ConsoleColor2();
        $this->setDefaultAlias(new NamespaceAdapter('cli'));
    }

    public function color($color, $text)
    {
        if (is_array($text) || is_object($text)) {
            $text = print_r($text, true);
        }
        $text = $this->_color->escape($text);
        return $this->_color->convert($color . $text . '%n');
    }

    public function dump($text, $color = '%m')
    {
        echo $this->color($color, $text) . "\n";
    }

    public function stderr($str, $stream = STDERR)
    {
        fwrite($stream, $str);
    }

    // abstract function
    public function buildCommand($path, $params)
    {
    }
    public function processHeader(array $headers)
    {
    }
    public function go($path, $isClientLocation = false)
    {
    }
}
