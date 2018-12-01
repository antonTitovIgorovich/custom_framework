<?php


namespace Framework\Console;


class Application
{
    /** @var Command[] */
    private $commands = [];

    public function add(Command $command)
    {
        $this->commands[] = $command;
    }

    public function run(Input $input, Output $output)
    {
        if ($name = $input->getArgument(0)) {
            $command = $this->resolveCommand($name);
            $command->execute($input, $output);
        } else {
            $this->renderHelp($output);
        }
    }

    private function resolveCommand($name): Command
    {
        foreach ($this->commands as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }
    }

    private function renderHelp(Output $output): void
    {
        $output->writeln('<comment>Available commands:</comment>');
        $output->writeln('');

        foreach ($this->commands as $command) {
            /** @var Command $command */
            $output->writeln('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
        }
        $output->writeln('');
    }
}