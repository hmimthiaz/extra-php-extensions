<?php

if (!function_exists($func = 'oci_connect')) {
    echo test . phpsprintf('FAIL: Function "%s" does not exist.', $func) . PHP_EOL;
    exit(1);
}

exit(0);
