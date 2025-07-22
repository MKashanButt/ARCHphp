<?php

namespace ARCHphp\Scripts;

use ARCHphp\CLI\CommandInput;

class Server
{
    public function run(CommandInput $input): void
    {
        $port = (int) ($input->getOption('port') ?? 8000);
        $command = sprintf('php -S %s:%d -t public', config('app.url'), $port);
        passthru($command);
    }
}
