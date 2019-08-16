<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class TouchTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'file',
        'time',
        'atime',
    ];
    public const NAME = 'touch';
}
