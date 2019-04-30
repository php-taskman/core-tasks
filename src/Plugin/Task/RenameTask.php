<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class RenameTask extends FilesystemTask
{
    const ARGUMENTS = [
        'from',
        'to',
        'force',
    ];
    const NAME = 'rename';
}
