<?php
namespace PMVC\PlugIn\cli;
${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\getopt';

class getopt
{

    private $_opts;

    function __invoke(array $args=[]) {
        if (empty($this->_opts)) {
            if (empty($args)) {
                $args = \PMVC\get($_SERVER, 'argv');
            }
            $this->_opts = $this->parse($args);
        }
        return $this->_opts;
    }

/**
 * Parses $GLOBALS['argv'] for parameters and assigns them to an array.
 *
 * Supports:
 * -e
 * -e <value>
 * --long-param
 * --long-param=<value>
 * --long-param <value>
 * <value>
 *
 */
    function parse($params) {
        $result = [];
        // could use getopt() here (since PHP 5.3.0), but it doesn't work relyingly
        $ignoreOnce = false;
        foreach ($params as $index=>$p) {
            if ($ignoreOnce) {
                $ignoreOnce = false;
                continue;
            }
            if ($p[0] === '-' && strlen($p) > 1) {
                $pname = substr($p, 1);
                $value = true;
                if ($pname[0] === '-') {
                    // long-opt (--<param>)
                    $pname = substr($pname, 1);
                    if (strpos($p, '=') !== false) {
                        // value specified inline (--<param>=<value>)
                        list($pname, $value) = explode('=', substr($p, 2), 2);
                    }
                }
                // check if next parameter is a descriptor or a value
                $nextparm = \PMVC\get($params, $index+1, false);
                if ($value === true && $nextparm !== false && $nextparm[0]!= '-') {
                    $ignoreOnce = true;
                    $value = $nextparm;
                }
                if (true === $value && 
                    '--' !== substr($p,0,2) &&
                    strlen($p) >= 3
                ) {
                    $value = substr($pname,1);
                    $pname = substr($pname,0,1);
                }
                $result[$pname] = $value;
            } else {
                // param doesn't belong to any option
                $result[] = $p;
            }
        }
        return $result;
    }
}
