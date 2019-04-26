<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\Task\AppendTask;
use Robo\Common\BuilderAwareTrait;
use Robo\Common\ResourceExistenceChecker;
use Robo\Contract\BuilderAwareInterface;
use Robo\Task\File\Write;

/**
 * Class AppendConfiguration.
 */
class AppendPhpTask extends BasePhpTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;
    use ResourceExistenceChecker;

    public const ARGUMENTS = [
        'file',
        'config',
        'blockEnd',
        'blockStart',
    ];
    public const NAME = 'append.php';

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
        $configurationBlock = $this->getConfigurationBlock();

        // First we remove it from the file if it exists.
        /** @var \Robo\Task\File\Write $writeTask */
        $writeTask = $this->task(Write::class, $arguments['file']);
        $content = str_replace($configurationBlock, '', $writeTask->originalContents());
        $tasksCollection[] = $writeTask->text($content);

        // Then we append the text.
        /** @var AppendTask $appendTask */
        $appendTask = $this->task(AppendTask::class);
        $appendTaskArguments = [
            'file' => $arguments['file'],
            'text' => $configurationBlock,
        ];
        $tasksCollection[] = $appendTask->setTaskArguments($appendTaskArguments);

        return $this
            ->collectionBuilder()
            ->addTaskList($tasksCollection)
            ->run();
    }
}
