<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class MirrorTask extends FilesystemTask
{
    const ARGUMENTS = [
        'from',
        'to',
    ];
    const NAME = 'mirror';
}
