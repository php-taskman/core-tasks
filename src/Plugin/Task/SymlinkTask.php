<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class SymlinkTask extends FilesystemTask
{
    const ARGUMENTS = [
        'from',
        'to',
        'copyOnWindows',
    ];
    const NAME = 'symlink';
}
