<?php
require_once 'vendor/autoload.php';
$response = new \Vineet\MathmaticalOperation\ConnectAPI('token');
echo $response->getAllOrdersOfDay(123);
