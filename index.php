<?php
require_once 'vendor/autoload.php';

$response = new \Vineet\MathmaticalOperation\Calculation();
echo $response->Add(12,13);

"//===============API test==============================//"
// $response = new \Vineet\MathmaticalOperation\ConnectAPI('token');
// echo $response->getAllOrdersOfDay(123);
