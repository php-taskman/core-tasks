<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use PhpTaskman\Core\Robo\Task\Filesystem\LoadFilesystemTasks;
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

    const ARGUMENTS = [
        'tasks',
        'options',
    ];
    const NAME = 'collectionFactory';

    /**
     * @var array
     */
    private $tasks;

    /**
     * @return string
     */
    public function getHelp()
    {
        return isset($this->tasks['help']) ? $this->tasks['help'] : 'Yaml command defined in tasks.yml';
    }

    /**
     * @return array
     */
    public function getTasks()
    {
        return isset($this->tasks['tasks']) ? $this->tasks['tasks'] : $this->tasks;
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
                $collection->addTask($this->taskExec($task));

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

            $collection->addTask($this->taskFactory($task));
        }

        return $collection->run();
    }

    /**
     * {@inheritdoc}
     */
    public function simulate($context)
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
    protected function secureOption(array &$task, $name, $default)
    {
        $task[$name] = isset($task[$name]) ? $task[$name] : $default;
    }

    /**
     * @param array $task
     *
     * @throws \Robo\Exception\TaskException
     *
     * @return \Robo\Contract\TaskInterface
     */
    protected function taskFactory(array $task)
    {
        $this->secureOption($task, 'force', false);
        $this->secureOption($task, 'umask', 0000);
        $this->secureOption($task, 'recursive', false);
        $this->secureOption($task, 'time', \time());
        $this->secureOption($task, 'atime', \time());
        $this->secureOption($task, 'mode', 0777);

        $arguments = \array_merge($task, $this->getTaskArguments()['options']);

        if (!Robo::getContainer()->has('task.' . $task['task'])) {
            throw new TaskException($this, 'Unkown task: ' . $task['task']);
        }

        /** @var \PhpTaskman\Core\Contract\TaskInterface $taskFactory */
        $taskFactory = Robo::getContainer()->get('task.' . $task['task']);
        $taskFactory->setTaskArguments($arguments);

        return $this
            ->collectionBuilder()
            ->addTaskList([
                $taskFactory,
            ]);
    }
}
