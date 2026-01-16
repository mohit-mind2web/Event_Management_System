<?php

// Load CodeIgniter's bootstrap file
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';

exit('CodeIgniter3/4 bootstrapping from outside is complex. I will try a simpler database connection or just use a controller modification to debug.');
