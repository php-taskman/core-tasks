<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\Core\Traits\ConfigurationTokensTrait;
use PhpTaskman\CoreTasks\Plugin\BaseTask;
use Robo\Common\BuilderAwareTrait;
use Robo\Common\ResourceExistenceChecker;
use Robo\Contract\BuilderAwareInterface;
use Robo\Result;
use Robo\Task\File\loadTasks;
use Robo\Task\File\Replace;
use Robo\Task\Filesystem\FilesystemStack;

final class ProcessTask extends BaseTask implements BuilderAwareInterface
{
    use BuilderAwareTrait;
    use loadTasks;
    use ResourceExistenceChecker;

    public const ARGUMENTS = [
        'from',
        'to',
    ];
    public const NAME = 'process';

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $arguments = $this->getTaskArguments();

        $from = $arguments['from'];
        $to = $arguments['to'];

        $filesystem = new FilesystemStack();
        $replace = new Replace($to);

        if (!$this->checkResource($from, 'file')) {
            return Result::error($this, "Source file '{$from}' does not exists.");
        }

        $sourceContent = \file_get_contents($from);

        if (false === $sourceContent) {
            return Result::error($this, "Unable to read source file '{$from}'.");
        }

        $tokens = $this->extractProcessedTokens($sourceContent);

        $tasks = [];
        if ($from !== $to) {
            $tasks[] = $filesystem->copy($from, $to, true);
        }
        $tasks[] = $replace->from(\array_keys($tokens))->to(\array_values($tokens));

        return $this->collectionBuilder()->addTaskList($tasks)->run();
    }

    /**
     * Extract tokens and replace their values with current configuration.
     *
     * @param string $text
     *
     * @return array
     */
    public function extractProcessedTokens($text): array
    {
        /** @var \Robo\Config\Config $config */
        $config = $this->getConfig();

        return \array_map(
            static function ($key) use ($config) {
                return $config->get($key);
            },
            $this->extractRawTokens($text)
        );
    }

    /**
     * Extract token in given text.
     *
     * @param string $text
     *
     * @return array
     */
    private function extractRawTokens($text): array
    {
        \preg_match_all('/\$\{(([A-Za-z_\-]+\.?)+)\}/', $text, $matches);

        if (isset($matches[0]) && !empty($matches[0]) && \is_array($matches[0])) {
            if (false !== $return = \array_combine($matches[0], $matches[1])) {
                return $return;
            }
        }

        return [];
    }
}
