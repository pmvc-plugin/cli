<?php
namespace PMVC\PlugIn\cmd;

class CmdParser
{
    public function arguments($args)
    {
        array_shift($args);
        $args = join($args, ' '). ' ';
        preg_match_all('/ (--\w+ (?:[= ] [^-]+ [^-] )? ) | (-\w+) | (\w+) /x', $args, $match);
        $args = array_shift($match);
        /*
           Array
           (
           [0] => asdf
           [1] => asdf
           [2] => --help
           [3] => --dest=/var/
           [4] => -asd
           [5] => -h
           [6] => --option mew arf moo
           [7] => -z
           )
         */

        $ret = array(
            'input'    => array(),
            'commands' => array(),
        );

        foreach ($args as $arg) {
            $parse = $this->parse_key($arg, 2);
            if (!$parse) {
                $parse = $this->parse_key($arg, 1);
            }
            if ($parse) {
                $ret['commands'][$parse['key']]=$parse['value'];
                continue;
            }
            $ret['input'][] = $arg;
        }
        return $ret;
    }
    public function parse_key($arg, $dash_num)
    {
        if (str_repeat('-', $dash_num)==substr($arg, 0, $dash_num)) {
            $value = preg_split('/[= ]/', $arg, $dash_num);
            $com   = substr(array_shift($value), $dash_num);
            $value = join($value);
            return array(
                    'key'=>$com
                    ,'value'=> trim($value) ?: true
                    );
        } else {
            return false;
        }
    }
}
