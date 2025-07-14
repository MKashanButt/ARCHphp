<?php

namespace ARCHphp\Scripts;

use ARCHphp\CLI\CommandInput;

class Models
{
    public function create(CommandInput $input)
    {
        $name = $input->getArg(0);
        $force = $input->hasFlag('--force');
        $fillable = explode(',', $input->getOption('--fillable', ''));

        if (!$name) {
            cli_echo("❌ Model name is required.", 'red');
            exit(1);
        }

        if ($force) {
            cli_echo("⚠️  Overwriting existing model", 'yellow');
        }

        $fillableArray = '';

        if (!empty($fillable) && $fillable[0] !== '') {
            $quotedFields = array_map(fn($f) => "'$f'", $fillable);
            $fillableArray = '[' . implode(', ', $quotedFields) . ']';
        } else {
            $fillableArray = '[]';
        }

        $stubPath = 'stubs/Model.stub';
        $output = "app/Models/$name.php";
        $variables = [
            'class' => $name,
            'fillable' => $fillableArray,
        ];

        $dir = dirname($output);
        if (!is_dir($dir)) {
            mkdir('app/' . $dir, 0755, true);
        }

        generateFileFromStub($stubPath, $variables, $output, [
            'force' => $force,
        ]);
    }

    public function delete(CommandInput $input)
    {
        $name = $input->getArg(0);
        if (!$name) {
            cli_echo("❌ Model name is required.", 'red');
            exit(1);
        }

        $filePath = "app/Models/$name.php";
        if (!file_exists($filePath)) {
            cli_echo("❌ Model '$name' does not exist.", 'red');
            exit(1);
        }

        if (unlink($filePath)) {
            cli_echo("Deleted model: $name");
        } else {
            cli_echo("❌ Failed to delete model: $name", 'red');
        }
    }
}
