<?php

namespace ARCHphp\Scripts;

class Controllers
{
    public function create(string $input = '')
    {
        if (empty($input)) {
            cli_echo("Please provide a controller name.", 'red');
            exit(1);
        }
        $stubPath = 'stubs/Controller.stub';
        $output = "app/Controllers/$input.php";
        $variables = [
            'class' => $input . 'Controller',
        ];

        $dir = dirname($output);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        generateFileFromStub($stubPath, $variables, $output);
    }
}
