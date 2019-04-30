<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class RemoveTask extends FilesystemTask
{
    const ARGUMENTS = [
        'file',
    ];
    const NAME = 'remove';
}
