<?php


namespace ARCHphp\CLI;

class CommandDispatcher
{
    protected array $commands;
    public function __construct(array $commands = [])
    {
        $this->commands = $commands;
    }
    public function handle(string $command, array $args = []): void
    {
        if (!isset($this->commands[$command])) {
            cli_echo("❌ Unknown command: '$command'", 'red');
            cli_echo("Use '--help' to see available commands.");
            exit(1);
        }

        $entry = $this->commands[$command];
        $handler = $entry['handler'] ?? $entry;

        $input = new CommandInput($args);

        if (is_array($handler)) {
            [$class, $method] = $handler;
            if (!method_exists($class, $method)) {
                cli_echo("❌ Method '$method' not found in $class", 'red');
                exit(1);
            }
            (new $class())->$method($input);
        } elseif (is_callable($handler)) {
            $handler($input);
        } else {
            cli_echo("❌ Invalid handler for command '$command'", 'red');
            exit(1);
        }
    }

    public function showHelp(): void
    {
        cli_echo("Available ARCHphp Commands:\n");

        foreach ($this->commands as $name => $meta) {
            if (!is_array($meta)) continue;
            $description = $meta['description'] ?? 'No description';
            printf("  - %-20s %s\n", $name, $description);
        }

        echo "\nRun `arch <command>` to execute.\n";
    }
}
