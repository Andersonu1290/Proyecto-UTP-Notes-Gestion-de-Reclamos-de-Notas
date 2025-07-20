<?php
require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

$redis = new Client([
    'host' => 'redis-12532.c14.us-east-1-2.ec2.redns.redis-cloud.com',
    'port' => 12532,
    'database' => 0,
    'username' => 'default',
    'password' => '3WfpSvuvzfsdQv8CUbBjiJDaVflwHi08',
]);
