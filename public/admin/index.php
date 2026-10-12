<?php

unset($_SERVER['PATH_INFO']);
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

require __DIR__.'/../index.php';
