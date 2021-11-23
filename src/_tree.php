<?php

namespace PMVC\PlugIn\cli;

use stdClass;
// https://github.com/wp-cli/php-cli-tools/blob/master/lib/cli/tree/Renderer.php
use cli\tree\Renderer;
// https://github.com/wp-cli/php-cli-tools/blob/master/lib/cli/Tree.php
use cli\Tree as CliTree;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\MyTree';

class MyTree
{
    private static $_cliTree;

    public function __invoke($data, $color = null, $stderr = null)
    {
        $tree = self::getInstance();
        if ($stderr) {
            $tree->setStdErr(true);
        }
        $tree->setData($data);
        $tree->setRenderer(new Markdown(4, $color));
        $tree->display();
    }

    public static function getInstance()
    {
        if (empty(self::$_cliTree)) {
            self::$_cliTree = new Tree();
        }
        return self::$_cliTree;
    }
}


/**
 * CLI Render
 *
 * @see cli\tree\Renderer
 */
class Markdown extends Renderer
{
    /**
     * How many spaces to indent by
     * @var int
     */
    protected $_padding;
    private $_color;

    /**
     * @param int $padding Optional. Default 2.
     */
    function __construct($padding = 2, $color = null)
    {
        $this->_padding = $padding;
        $this->_color = $color;
    }

    /**
     * Renders the tree
     *
     * @param array $tree
     * @param int $level Optional
     * @return string
     */
    public function render(array $tree, $level = 0)
    {
        $output = '';
        $cli = \PMVC\plug('cli');
        foreach ($tree as $label => $next) {
            $content = null;
            if (is_object($next) && $next instanceof stdClass) {
                $next = (array) $next;
            }
            if (!is_array($next)) {
                if (is_object($next) && !method_exists($next, '__string')) {
                    $content = ': ' . get_class($next);
                } else {
                    $content = ': ' . var_export($next, true);
                }
            }
            $color = !$level ? $this->_color : '%_';
            $label = $cli->color($color, $label);

            // Output the label
            $output .= sprintf(
                "%s- %s%s\n",
                str_repeat(' ', $level * $this->_padding),
                $label,
                $content
            );

            // Next level
            if (is_array($next)) {
                $output .= $this->render($next, $level + 1);
            }
        }

        return $output;
    }
}

class Tree extends CliTree
{
    private $_err = false;

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
            \PMVC\plug('cli')->stderr($this->render());
            $this->setStdErr(false);
        } else {
            echo $this->render();
        }
    }
}
