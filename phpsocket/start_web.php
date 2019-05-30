<?php
use Workerman\WebServer;
use Workerman\Worker;
include dirname(__DIR__) . '/vendor/autoload.php';
// launch a new webserver
// this webserver is optional
$web = new WebServer('http://0.0.0.0:2123');
$web->addRoot('localhost', dirname(__DIR__) . '/web');
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
