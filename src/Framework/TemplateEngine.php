<?php
declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(
        private string $basePath
    )
    {

    }

    /**
     * returns includes paths
     * param $data contains data for template
     */
    public function render(string $template, array $data = []){

        //create variables according to key in associative array
        //$data['title'] => $title = value
        //accessible in template
        extract($data, EXTR_OVERWRITE);

        //starts output buffer, we can manipulate before is rendered
        ob_start();

        //can be replaced with resolve method
        //include "{$this->basePath}/{$template}";
        include $this->resolve($template);

        //method search for active output buffer, contents from buffer will be returned as string
        $output = ob_get_contents();

        //end buffer feature and content will be erased
        //always clean
        ob_end_clean();

        //merthod returns conntent of the buffer
        return $output;
    }

    public function resolve(string $path){
        return "{$this->basePath}/{$path}";
    }

}