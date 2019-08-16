<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use Robo\Common\BuilderAwareTrait;
use Robo\Common\ResourceExistenceChecker;
use Robo\Contract\BuilderAwareInterface;
use Robo\Task\File\Write;

/**
 * Class PrependConfiguration.
 */
class PrependPhpTask extends BasePhpTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;
    use ResourceExistenceChecker;

    public const ARGUMENTS = [
        'file',
        'config',
        'blockEnd',
        'blockStart',
    ];
    public const NAME = 'prepend.php';

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
        $content = \str_replace(
            [$configurationBlock, '<?php'],
            '',
            $writeTask->originalContents()
        );
        $tasksCollection[] = $writeTask->text($content);

        // Then we prepend the text.
        /** @var AppendTask $appendTask */
        $appendTask = $this->task(PrependTask::class);
        $appendTaskArguments = [
            'file' => $arguments['file'],
            'text' => "<?php\n" . $configurationBlock,
        ];
        $tasksCollection[] = $appendTask->setTaskArguments($appendTaskArguments);

        return $this
            ->collectionBuilder()
            ->addTaskList($tasksCollection)
            ->run();
    }
}
