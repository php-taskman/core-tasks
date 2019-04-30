<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class MkdirTask extends FilesystemTask
{
    const ARGUMENTS = [
        'dir',
        'mode',
    ];
    const NAME = 'mkdir';
}
