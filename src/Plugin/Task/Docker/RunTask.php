<?php

namespace PhpTaskman\CoreTasks\Plugin\Task\Docker;

use PhpTaskman\Core\Robo\Task\Filesystem\Filesystem;
use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Task\Docker\Exec;
use Robo\Task\Docker\Run;

final class RunTask extends BaseTask
{
    const ARGUMENTS = [
        'detached',
        'exec',
        'image',
        'name',
        'tty',
    ];

    const NAME = 'docker.run';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        $task = $this->task(Run::class, $arguments['image']);

        $arguments += array(
            'detached' => false,
            'interactive' => true,
            'tty' => false,
        );

        if ($arguments['tty'] === true) {
            $task->option('-t');
        }

        if ($arguments['detached'] === true) {
            $task->detached();
        }

        return $task
            ->exec($arguments['exec'])
            ->run();
    }
}
