<?php


namespace Framework\Console;


class Input
{
    private $argv;

    public function __construct(array $argv)
    {
        $this->argv = array_slice($argv, 1);
    }

    public function getArgument(int $index): string
    {
        return $this->argv[$index] ?? '';
    }

    public function choose(string $prompt, array $options): string
    {
        do {
            fwrite(\STDOUT, $prompt . ' [' . implode(',', $options) . ']: ');
            $choose = trim(fgets(\STDIN));
        } while (!\in_array($choose, $options, true));
        return $choose;
    }
}