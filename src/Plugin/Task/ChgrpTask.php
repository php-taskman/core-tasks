<?php

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChgrpTask extends FilesystemTask
{
    const ARGUMENTS = [
        'file',
        'group',
        'recursive',
    ];
    const NAME = 'chgrp';
}
