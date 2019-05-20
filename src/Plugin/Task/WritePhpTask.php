<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use Robo\Common\BuilderAwareTrait;
use Robo\Contract\BuilderAwareInterface;
use Robo\Task\File\Write;

/**
 * Class WriteConfiguration.
 */
class WritePhpTask extends BasePhpTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;

    public const ARGUMENTS = [
        'file',
        'config',
        'blockEnd',
        'blockStart',
    ];

    public const NAME = 'write.php';

    /**
     * @throws \Robo\Exception\TaskException
     *
     * @return \Robo\Result
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        /** @var \Robo\Task\File\Write $writeTask */
        $writeTask = $this->task(Write::class, $arguments['file']);

        /** @var ProcessTask $processTask */
        $processTask = $this->task(ProcessTask::class);
        $processTaskArguments = [
            'from' => $arguments['file'],
            'to' => $arguments['file'],
        ];

        $text = "<?php\n" . $this->getConfigurationBlock();

        return $this
            ->collectionBuilder()
            ->addTaskList([
                $writeTask->text($text),
                $processTask->setTaskArguments($processTaskArguments),
            ])
            ->run();
    }
}
