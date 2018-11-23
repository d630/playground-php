<?php

declare(strict_types=1);

use D630\Corg\Util;

return [
    'upload_dir' => realpath(Util::buildFilePath('..', 'var')),
];
