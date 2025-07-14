<?php

namespace ARCHphp\CLI;

class CommandInput
{
    public array $args = [];
    public array $options = [];
    public array $flags = [];

    public function __construct(array $rawArgs)
    {
        foreach ($rawArgs as $arg) {
            if (str_starts_with($arg, '--')) {
                if (str_contains($arg, '=')) {
                    [$key, $val] = explode('=', ltrim($arg, '-'), 2);
                    $this->options["--$key"] = $val;
                } else {
                    $this->flags[] = $arg;
                }
            } else {
                $this->args[] = $arg;
            }
        }
    }

    public function getArg(int $index, mixed $default = null): mixed
    {
        return $this->args[$index] ?? $default;
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        return $this->options[$name] ?? $default;
    }

    public function hasFlag(string $flag): bool
    {
        return in_array($flag, $this->flags);
    }
}
