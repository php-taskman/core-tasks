<?php

declare(strict_types=1);

namespace PhpTaskman\CoreTasks\Plugin\Task;

use PhpTaskman\CoreTasks\Plugin\FilesystemTask;

final class ChgrpTask extends FilesystemTask
{
    public const ARGUMENTS = [
        'file',
        'group',
        'recursive',
    ];
    public const NAME = 'chgrp';
}
