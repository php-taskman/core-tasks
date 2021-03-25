<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Common\BuilderAwareTrait;
use Robo\Contract\BuilderAwareInterface;
use Robo\Task\Base\Exec;

/**
 * Class YamlTask.
 */
final class YamlTask extends BaseTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;
    use \Robo\Task\File\Tasks;

    /**
     * @var array
     */
    private $definition;

    /**
     * YamlTask constructor.
     */
    public function __construct(array $definition)
    {
        $this->definition = $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $tasks = $this->definition;

        if (isset($tasks['tasks'])) {
            $tasks = (array) $tasks['tasks'];
        }

        $collectionBuilder = $this->collectionBuilder();

        foreach ($tasks as $task) {
            $task = $this->task(Exec::class, $task);
            $task->setVerbosityThreshold($this->verbosityThreshold());

            $collectionBuilder->addTask($task);
        }

        return $collectionBuilder->run();
    }
}
