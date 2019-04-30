<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChownTask extends FilesystemTask
{
    const ARGUMENTS = [
        'file',
        'user',
        'recursive',
    ];
    const NAME = 'chown';
}
