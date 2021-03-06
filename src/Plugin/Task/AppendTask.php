<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Task\File\Tasks;

final class AppendTask extends BaseTask
{
    use Tasks;

    public const ARGUMENTS = [
        'file',
        'text',
    ];

    public const NAME = 'append';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        /** @var \PhpTaskman\CoreTasks\Plugin\Task\ProcessTask $processTask */
        $processTask = $this->task(ProcessTask::class);
        $processTask->setTaskArguments([
            'from' => $arguments['file'],
            'to' => $arguments['file'],
        ]);

        return $this->collectionBuilder()->addTaskList([
            $this->taskWriteToFile($arguments['file'])->append()->text($arguments['text']),
            $processTask,
        ])->run();
    }
}
