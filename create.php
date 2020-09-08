<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'exchangeRateUSD.php';

$database = new Database();
$db = $database->getConnection();

$ExchangeRateUSD = new ExchangeRateUSD($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->currency) && !empty($data->rate)) {
	$ExchangeRateUSD->currency = $data->currency;
	$ExchangeRateUSD->rate = $data->rate;

	if($ExchangeRateUSD->create()) {
		http_response_code(201);
		echo json_encode(array("http_response_code" => "201", "message" => "Exchange rate was created."));
	}

	else {
	    http_response_code(503);
		echo json_encode(array("message" => "Unable to add new exchange rate."));
	}
}

else {
	http_response_code(400);
	echo json_encode(array("message" => "Unable to add new exchange rate, data incomplete."));
}
?>

