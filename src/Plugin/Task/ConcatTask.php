<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Common\BuilderAwareTrait;
use Robo\Task\File\Tasks;

final class ConcatTask extends BaseTask
{
    use BuilderAwareTrait;
    use Tasks;

    public const ARGUMENTS = [
        'files',
        'to',
    ];

    public const NAME = 'concat';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        /** @var \PhpTaskman\CoreTasks\Plugin\Task\ProcessTask $processTask */
        $processTask = $this->task(ProcessTask::class);
        $processTask->setTaskArguments([
            'from' => $arguments['to'],
            'to' => $arguments['to'],
        ]);

        return $this
            ->collectionBuilder()
            ->addTaskList([
                $this->taskConcat($arguments['files'])->to($arguments['to']),
                $processTask,
            ])
            ->run();
    }
}
