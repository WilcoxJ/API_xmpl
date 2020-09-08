<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once 'config/database.php';
include_once 'exchangeRateUSD.php';

$database = new Database();
$db = $database->getConnection();

$exchangeRateUSD = new ExchangeRateUSD($db);

$stmt = $exchangeRateUSD->read();
$num = $exchangeRateUSD->count();

if($num>0) {
	$exchangeRateUSD_arr=array();
	$exchangeRateUSD_arr["records"]=array();

	while ($row = sqlsrv_fetch_array($stmt)) {
		extract($row);

		$rate_record=array(
			"id" => $id,
			"currency" => $currency,
			"rate" => $rate
		);

		array_push($exchangeRateUSD_arr["records"], $rate_record);
	}

	http_response_code(200);
	echo json_encode($exchangeRateUSD_arr);
}

else {
	http_response_code(404);
	echo json_encode(
		array("message" => "No exchange rates found.")
	);
}