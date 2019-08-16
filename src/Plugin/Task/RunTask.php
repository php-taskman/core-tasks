<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Common\BuilderAwareTrait;
use Robo\Exception\TaskException;
use Robo\Robo;
use Robo\Task\Base\loadTasks;

final class RunTask extends BaseTask
{
    use BuilderAwareTrait;
    use loadTasks;

    public const ARGUMENTS = [
        'options',
        'command',
    ];
    public const NAME = 'run';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        $arguments += [
            'options' => [],
        ];

        $bin = $this->getConfig()->get('options.bin', null);

        if (null === $bin) {
            throw new TaskException(__CLASS__, 'Unable to find the taskman binary');
        }

        $taskExec = $this->taskExec($bin)->arg($arguments['command']);

        $container = Robo::getContainer();

        /** @var \Robo\Application $app */
        $app = $container->get('application');

        /** @var \Consolidation\AnnotatedCommand\AnnotatedCommand $command */
        $command = $app->get($arguments['command']);
        $commandOptions = $command->getDefinition()->getOptions();

        // Propagate any input option passed to the child command.
        foreach ($arguments as $name => $values) {
            if (!isset($commandOptions[$name])) {
                continue;
            }

            // But only if the called command has this option.
            foreach ((array) $values as $value) {
                $taskExec->option($name, $value);
            }
        }

        return $taskExec->run();
    }
}
