<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class CopyTask extends FilesystemTask
{
    const ARGUMENTS = [
        'from',
        'to',
        'force',
    ];
    const NAME = 'copy';
}
