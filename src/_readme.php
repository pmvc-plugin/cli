<?php

namespace PMVC\PlugIn\cli;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\readme';

class readme
{
    public function __invoke() {
        $app = \PMVC\plug(_RUN_APP);
        $file = \PMVC\realPath($app->getDir().'index_cli.md');
        if ($file) {
          return file_get_contents($file);
        }
    }
}
