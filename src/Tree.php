<?php

namespace PMVC\PlugIn\cli;

// https://github.com/wp-cli/php-cli-tools/blob/master/lib/cli/Tree.php
use cli\Tree as CliTree;

class Tree extends CliTree
{
    private $_err = false;
    protected $errStream = STDERR;

    public function setStdErr($bool)
    {
        $this->_err = $bool; 
    }

    /**
     * Display the rendered tree
     */
    public function display()
    {
        if ($this->_err) {
            fwrite($this->errStream, $this->render());
            $this->setStdErr(false);
        } else {
            echo $this->render();
        }
    }
}
