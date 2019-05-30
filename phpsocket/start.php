<?php
/**
 * run with command
 * php start.php start
 */
use Workerman\Worker;
// load the autoload.php in vendor
include dirname(__DIR__) . '/vendor/autoload.php';
if (strpos(strtolower(PHP_OS), 'win') === 0) {
    exit("start.php not support windows, please use start_for_win.bat\n");
}
// start globally
define('GLOBAL_START', 1);
// load io and web
require_once __DIR__ . '/start_io.php';
require_once __DIR__ . '/start_web.php';
// launch all the services
Worker::runAll();
