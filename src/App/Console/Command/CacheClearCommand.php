<?php

namespace App\Console\Command;

use Framework\Console\Input;
use Framework\Console\Output;
use App\Service\FileManager;
use Framework\Console\Command;

class CacheClearCommand extends Command
{
    protected $paths;

    protected $fileManager;

    public function __construct(array $paths, FileManager $fileManager)
    {
        $this->paths = $paths;
        $this->fileManager = $fileManager;

        parent::__construct();

    }

    protected function configure(): void
    {
        $this->setName('clear:cache')->setDescription('Clear cache');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->process('<comment>Clearing cache</comment>');

        $alias = $input->getArgument(1);

        if (empty($alias)) {
            $alias = $input->choose('Choose path', array_merge(array_keys($this->paths), ['all']));
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        } else {
            if (!array_key_exists($alias, $this->paths)) {
                throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
            }
            $paths = [$alias => $this->paths[$alias]];
        }

        foreach ($paths as $path) {
            if ($this->fileManager->exists($path)) {
                $output->writeln('Remove ' . $path);
                $this->fileManager->delete($path);
            } else {
                $output->writeln('<info>Skip</info> ' . $path);
            }
        }

        $output->process('<info>Done!</info>');
    }
}