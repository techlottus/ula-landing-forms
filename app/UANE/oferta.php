<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 

include_once 'Config.php';

function conecta() {
    $response = array();
	
	/*Conexion SF*/	
	$urlAccessToken    = 'https://lottus.my.salesforce.com/services/oauth2/token?client_id='.CLIENT_ID.'&client_secret='.CLIENT_SECRET.'&username='.USER_NAME.'&password='.PASS;
	$urlCourseOffering = 'https://lottus.my.salesforce.com/services/apexrest/hed__Course_Offering__c?linea=ULA';
	$urlCourseOfferingUANE = 'https://lottus.my.salesforce.com/services/apexrest/hed__Course_Offering__c?linea=UANE';
	$grantType         = 'password';
	$clientId          = CLIENT_ID;
	$clientSecret      = CLIENT_SECRET;
	$username          = USER_NAME;
	$password          = PASS;

	// Access request
	$content = [
		'grant_type'    => $grantType,
		'client_id'     => $clientId,
		'client_secret' => $clientSecret,
		'username'      => $username,
		'password'      => $password
	];
	$options = [
		'http' => [
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($content)
		]
	];
	$context  = stream_context_create($options);
	$access =  file_get_contents($urlAccessToken, false, $context);

    if ( $access === false ) {
		$response["error"] = true;
        $response["message"] = "No se pudo conectar a SF";
        
    } else {
		$token = json_decode($access);
		$options = [
			'http' => [
				'header' => "Authorization: {$token->token_type} {$token->access_token}\r\n",
				'method' => 'GET'
			]
		];
		$context  = stream_context_create($options);
        $offering =  file_get_contents($urlCourseOffering, false, $context);
	    $offeringUANE =  file_get_contents($urlCourseOfferingUANE, false, $context);
		
		if($offering === false && $offeringUANE  === false) {
			$response["error"] = true;
			$response["message"] = "No se pudo obtener la oferta acedemica";
		} else {
			$response = array_merge(json_decode($offering, true),json_decode($offeringUANE, true));
		}
		
    }
	
    echoResponse(201, $response);
}

conecta();

function echoResponse($status_code, $response) {
    echo json_encode($response);
}

?>