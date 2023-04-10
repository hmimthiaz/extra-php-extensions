<?php
$jpg_file = __DIR__ . '/images/sample.jpg';
$png_file = __DIR__ . '/images/sample.png';
$gif_file = __DIR__ . '/images/sample.gif';
$bin_folder = "/opt/bin";

function get_temp_file($ext)
{
    return escapeshellarg(tempnam(sys_get_temp_dir(), 'ig' . rand(1111, 9999)) . '.' . $ext);
}

exec($bin_folder . "/jpegoptim --verbose --stdout " . escapeshellarg($jpg_file) . " > " . get_temp_file('jpg'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: jpegoptim' . PHP_EOL;
    exit(1);
}

exec($bin_folder . "/optipng -v --force -backup " . escapeshellarg($png_file) . " -out=" . get_temp_file('png'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: optipng' . PHP_EOL;
    exit(1);
}

exec($bin_folder . "/pngquant --verbose --force " . escapeshellarg($png_file) . " --output=" . get_temp_file('png'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: pngquant' . PHP_EOL;
    exit(1);
}

exec($bin_folder . "/gifsicle --verbose --optimize " . escapeshellarg($gif_file) . " --output " . get_temp_file('gif'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: gifsicle' . PHP_EOL;
    exit(1);
}

exec($bin_folder . "/cwebp -v " . escapeshellarg($jpg_file) . " -o " . get_temp_file('webp'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: cwebp jpg ' . PHP_EOL;
    exit(1);
}

exec($bin_folder . "/cwebp -v " . escapeshellarg($png_file) . " -o " . get_temp_file('webp'), $output, $return_status);
if ($return_status != 0) {
    echo 'Failed: cwebp png ' . PHP_EOL;
    exit(1);
}

exit(0);
