<?php

/** One-off: rewrite legacy wp-* paths in public CSS after images/ reorg. */

$dir = dirname(__DIR__) . '/public/asset/css';
foreach (glob($dir . '/*.css') ?: [] as $f) {
    $t = file_get_contents($f);
    $n = str_replace(
        [
            '../images/wp-content/',
            '../images/wp-uploads/sites/24/images/lightGallery/',
            '../images/wp-uploads/sites/24/2021/03/',
            'url("https:../images/wp-uploads/sites/24/2022/08/parallax-block-21-1919x1102-1.jpg")',
        ],
        [
            '../images/vendor/',
            '../images/media/lightgallery/',
            '../images/media/demo/',
            'url("../images/media/demo/01-6-1-1.jpg")',
        ],
        $t
    );
    $n = str_replace('../images/wp-uploads/', '../images/media/demo/', $n);
    if ($n !== $t) {
        file_put_contents($f, $n);
        fwrite(STDOUT, "updated: {$f}\n");
    }
}
