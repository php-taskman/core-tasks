[![Latest Stable Version](https://img.shields.io/github/release/php-taskman/core-tasks.svg?style=flat-square)](https://packagist.org/packages/phptaskman/coretasks)
 [![Stars](https://img.shields.io/github/stars/php-taskman/core-tasks.svg?style=flat-square)](https://github.com/php-taskman/core-tasks)
 [![Total Downloads](https://img.shields.io/packagist/dt/phptaskman/coretasks.svg?style=flat-square)](https://packagist.org/packages/phptaskman/coretasks)
 [![Build Status](https://img.shields.io/travis/php-taskman/core-tasks/master.svg?style=flat-square)](https://travis-ci.org/php-taskman/core-tasks)
 [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/php-taskman/core-tasks.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-taskman/core-tasks/?branch=master)
 [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-taskman/core-tasks.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-taskman/core-tasks/?branch=master)
 [![License](https://img.shields.io/github/license/php-taskman/core-tasks.svg?style=flat-square)](https://packagist.org/packages/phptaskman/coretasks)
 
# Taskman Core Tasks

Taskman Core tasks.

## Default tasks

| Task          | Arguments |
| ------------- | --------- |
| `append`      | `file`, `text` |
| `append.php`  | `file`, `config` |
| `chgrp`       | `file`, `group`, `recursive` (false) |
| `chmod`       | `file`, `permissions`, `umask` (0000), `recursive` (false) |
| `chown`       | `file`, `user`, `recursive` (false) |
| `concat`      | `files`, `to` |
| `copy`        | `from`, `to`, `force` (false) |
| `mirror`      | `from`, `to` |
| `mkdir`       | `dir`, `mode` (0777) |
| `prepend`     | `file`, `text` |
| `prepend.php` | `file`, `config` |
| `process`     | `from`, `to` |
| `remove`      | `file` |
| `rename`      | `from`, `to`, `force` (false) |
| `symlink`     | `from`, `to`, `copyOnWindows` (false) |
| `touch`       | `file`, `time` (current time), `atime` (current time) |
| `write`       | `file`, `text` |
| `run`         | `command` (will run `./vendor/bin/taskman [command]`) |
