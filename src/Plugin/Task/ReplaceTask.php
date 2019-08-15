<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use Robo\Common\BuilderAwareTrait;
use Robo\Common\ResourceExistenceChecker;
use Robo\Contract\BuilderAwareInterface;
use Robo\Task\File\Replace;

/**
 * Class Replace.
 */
class ReplaceTask extends BasePhpTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;
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
