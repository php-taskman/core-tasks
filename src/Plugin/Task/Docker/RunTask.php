<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task\Docker;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Task\Docker\Run;

final class RunTask extends BaseTask
{
    public const ARGUMENTS = [
        'detached',
        'dir',
        'exec',
        'image',
        'name',
        'rm',
        'tty',
        'volume',
    ];

    public const NAME = 'docker.run';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        /** @var \Robo\Task\Docker\Run $task */
        $task = $this->task(Run::class, $arguments['image']);

        $arguments += [
            'detached' => false,
            'interactive' => true,
            'tty' => false,
            'volume' => null,
            'dir' => getcwd(),
            'rm' => true,
        ];

        if (true === $arguments['tty']) {
            $task->option('-t');
        }

        if (true === $arguments['detached']) {
            $task->detached();
        }

        if (null !== $arguments['volume']) {
            $volume = explode(':', $arguments['volume'], 2);

            $task->volume($volume[0], $volume[1]);
        }

        if (null !== $arguments['dir']) {
            $task->containerWorkdir($arguments['dir']);
        }

        if (true === $arguments['rm']) {
            $task->option('--rm');
        }

        return $task
            ->exec($arguments['exec'])
            ->run();
    }
}
