<?php

namespace ARCHphp\Scripts;

class Server
{
    public function run(int $port): void
    {
        $command = 'php -S 127.0.0.1:' . $port;
        passthru($command);
    }
}
