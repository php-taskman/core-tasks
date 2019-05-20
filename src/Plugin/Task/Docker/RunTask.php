<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task\Docker;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
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

        $arguments += [
            'detached' => false,
            'interactive' => true,
            'tty' => false,
        ];

        if (true === $arguments['tty']) {
            $task->option('-t');
        }

        if (true === $arguments['detached']) {
            $task->detached();
        }

        return $task
            ->exec($arguments['exec'])
            ->run();
    }
}
