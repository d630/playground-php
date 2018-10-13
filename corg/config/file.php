<?php

ini_set('file_uploads', '1');
// ini_set('upload_tmp_dir', 'data/');
ini_set('upload_max_filesize', '5M');
ini_set('max_file_uploads', 1);
ini_set('post_max_size', '20M');
ini_set('memory_limit', '128M');

return [
    'upload_dir' => '../var/',
];
