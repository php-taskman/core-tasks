<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChmodTask extends FilesystemTask
{
    const ARGUMENTS = [
        'file',
        'permissions',
        'umask',
        'recursive',
    ];
    const NAME = 'chmod';
}
