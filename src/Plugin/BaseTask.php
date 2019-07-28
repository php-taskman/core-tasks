<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin;

use PhpTaskman\Core\Contract\TaskInterface;
use Robo\Contract\BuilderAwareInterface;
use Robo\TaskAccessor;

abstract class BaseTask extends \Robo\Task\BaseTask implements BuilderAwareInterface, TaskInterface
{
    use TaskAccessor;

    public const ARGUMENTS = [];
    public const NAME = 'NULL';

    /**
     * @var array
     */
    private $arguments;

    /**
     * {@inheritdoc}
     */
    public function getTaskArguments()
    {
        $argumentsAllowed = array_combine(
            static::ARGUMENTS,
            static::ARGUMENTS
        );

        if (empty($argumentsAllowed)) {
            $arguments = $this->arguments;
            unset($arguments['task']);

            return $arguments;
        }

        $arguments = [];

        foreach ($argumentsAllowed as $argumentName) {
            if (!isset($this->arguments[$argumentName])) {
                continue;
            }

            $arguments[$argumentName] = $this->arguments[$argumentName];
        }

        return $arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaskArguments(array $arguments = [])
    {
        $this->arguments = $arguments;

        return $this;
    }
}
