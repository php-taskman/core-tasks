<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class MkdirTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'dir',
        'mode',
    ];
    public const NAME = 'mkdir';
}
