<?php
date_default_timezone_set('prc');
require('autoload.php');
Autoload::instance()->init();
$query = "{query}";
new \workflow\app\Conversion($query);
