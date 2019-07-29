<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\Core\Robo\Task\Filesystem\LoadFilesystemTasks;
use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Contract\BuilderAwareInterface;
use Robo\Contract\SimulatedInterface;
use Robo\Exception\TaskException;
use Robo\LoadAllTasks;
use Robo\Robo;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CollectionFactoryTask.
 *
 * Return a task collection given its array representation.
 */
final class CollectionFactoryTask extends BaseTask implements
    BuilderAwareInterface,
    SimulatedInterface
{
    use LoadAllTasks;
    use LoadFilesystemTasks;

    public const ARGUMENTS = [
        'tasks',
        'options',
    ];
    public const NAME = 'collectionFactory';

    /**
     * @var array
     */
    private $tasks;

    /**
     * @return string
     */
    public function getHelp()
    {
        return $this->tasks['help'] ?? 'Yaml command defined in tasks.yml';
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return $this->tasks['tasks'] ?? $this->tasks;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();
        $collection = $this->collectionBuilder();

        foreach ($arguments['tasks'] as $task) {
            if (\is_string($task)) {
                $task = $this->taskExec($task);
                $task->setVerbosityThreshold($this->verbosityThreshold());
                $collection->addTask($task);

                continue;
            }

            if (!\is_array($task)) {
                // Todo: Error.
                continue;
            }

            if (!isset($task['task'])) {
                // Todo: Error.
                continue;
            }

            if (!\is_string($task['task'])) {
                // Todo: Error.
                continue;
            }

            $task = $this->taskFactory($task);
            $task->setVerbosityThreshold($this->verbosityThreshold());
            $collection->addTask($task);
        }

        return $collection->run();
    }

    /**
     * {@inheritdoc}
     */
    public function simulate($context): void
    {
        foreach ($this->getTasks() as $task) {
            if (\is_array($task)) {
                $task = Yaml::dump($task, 0);
            }

            $this->printTaskInfo($task, $context);
        }
    }

    /**
     * Secure option value.
     *
     * @param array  $task
     * @param string $name
     * @param mixed  $default
     */
    protected function secureOption(array &$task, $name, $default): void
    {
        $task[$name] = $task[$name] ?? $default;
    }

    /**
     * @param array $task
     *
     * @return \PhpTaskman\Core\Contract\TaskInterface
     */
    protected function taskFactory(array $task)
    {
        $this->secureOption($task, 'force', false);
        $this->secureOption($task, 'umask', 0000);
        $this->secureOption($task, 'recursive', false);
        $this->secureOption($task, 'time', time());
        $this->secureOption($task, 'atime', time());
        $this->secureOption($task, 'mode', 0777);

        $arguments = array_merge($task, $this->getTaskArguments()['options']);

        if (!Robo::getContainer()->has('task.' . $task['task'])) {
            throw new TaskException($this, 'Unknown task: ' . $task['task']);
        }

        /** @var \PhpTaskman\Core\Contract\TaskInterface $taskFactory */
        $taskFactory = Robo::getContainer()->get('task.' . $task['task']);
        $taskFactory->setTaskArguments($arguments);

        return $taskFactory;
    }
}
