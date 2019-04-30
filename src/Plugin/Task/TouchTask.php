<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class TouchTask extends FilesystemTask
{
    const ARGUMENTS = [
        'file',
        'time',
        'atime',
    ];
    const NAME = 'touch';
}
