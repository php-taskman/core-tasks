<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Common\ResourceExistenceChecker;
use Robo\Task\File\Replace;

/**
 * Class Replace.
 */
class ReplaceTask extends BaseTask
{
    use ResourceExistenceChecker;

    public const ARGUMENTS = [
        'file',
        'from',
        'to',
    ];
    public const NAME = 'replace';

    /**
     * @throws \Robo\Exception\TaskException
     *
     * @return \Robo\Result
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        if (!$this->checkResource($arguments['file'], 'file')) {
            return;
        }

        $tasksCollection = [];

        /** @var \Robo\Task\File\Replace $replaceTask */
        $replaceTask = $this->task(Replace::class, $arguments['file']);
        $tasksCollection[] = $replaceTask->from($arguments['from'])->to($arguments['to']);

        return $this
            ->collectionBuilder()
            ->addTaskList($tasksCollection)
            ->run();
    }
}
