<?php

declare(strict_types = 1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class SymlinkTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'from',
        'to',
        'copyOnWindows',
    ];
    public const NAME = 'symlink';
}
