<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class RemoveTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'file',
    ];

    public const NAME = 'remove';
}
