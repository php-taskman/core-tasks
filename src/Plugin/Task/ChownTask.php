<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChownTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'file',
        'user',
        'recursive',
    ];
    public const NAME = 'chown';
}
