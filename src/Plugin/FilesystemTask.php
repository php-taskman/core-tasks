<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin;

use PhpTaskman\Core\Robo\Task\Filesystem\Filesystem;
use PhpTaskman\Core\Robo\Task\Filesystem\LoadFilesystemTasks;

abstract class FilesystemTask extends BaseTask
{
    use LoadFilesystemTasks;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $task = static::NAME;
        $arguments = \array_values($this->getTaskArguments());

        return $this->task(Filesystem::class)->{$task}(...$arguments)->run();
    }
}
