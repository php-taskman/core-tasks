<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class CopyTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'from',
        'to',
        'force',
    ];
    public const NAME = 'copy';
}
