<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class MirrorTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'from',
        'to',
    ];
    public const NAME = 'mirror';
}
