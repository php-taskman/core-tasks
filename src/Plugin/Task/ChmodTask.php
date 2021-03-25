<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChmodTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'file',
        'permissions',
        'umask',
        'recursive',
    ];

    public const NAME = 'chmod';
}
