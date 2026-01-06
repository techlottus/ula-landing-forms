<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
function get_sf_auth_data()
{
  $post_data = [
    "grant_type" => "password",
    "client_id" =>
      "3MVG9LBJLApeX_PAaOZZnyLX4MdUEQQ3Uvh67OB.CUsoBo5VPlhI7Y92gdagNcjsXblunkDI18KLBA6nY2tL7",
    "client_secret" =>
      "011D2286679B186BFB5928E679F069E9E9F81ACDFCE7CE3F713D65CD713B8309",
    "username" => "utc_integracion@lottuseducation.com",
    "password" => "UTC2025*Lottushxo9mDAXplVlK5JWvcj9y4dHf",
  ]; /*
		dev
	    //$post_data = array(
			'grant_type'    => 'password',
			'client_id'     => '3MVG99E3Ry5mh4zqNsp6HovAR3tS3NeYEVQONW0WsP9aXUskYrkv27OFreLtfhrG6meW.sg3zlapdd6UTcyXc',
			'client_secret' => '602EB23E8FBD0BD4EDD452DDECA080ADFA48CDDB6712789904307606FD78210C',
			'username'      => 'integrationuser@cloudco.com.mx.dev',
			'password'      => 'Cloudco01FeuhyF053CnqlNE5gePoz2snF'
		);*/
  //end dev

  $headers = [
    "Content-type" => "application/x-www-form-urlencoded;charset=UTF-8",
  ];

  $curl = curl_init("https://lottus.my.salesforce.com/services/oauth2/token");
  //dev
  //	$curl = curl_init('https://lottus--dev.my.salesforce.com/services/oauth2/token');
  //end dev

  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

  $response = curl_exec($curl);
  unset($curl);

  // Retrieve and parse response body
  $sf_access_data = json_decode($response, true);

  return $sf_access_data;
}

if (isset($_GET["linea"])) {
  $linea = $_GET["linea"];
} else {
  $linea = "UTC";
}

$sf_access_data = get_sf_auth_data();
$instance_url = $sf_access_data["instance_url"];
$url = "$instance_url/services/apexrest/hed__Course_Offering__c?linea=$linea";
//dev
//	$url = "$instance_url/services/apexrest/hed__Course_Offering__c?linea=ULA";
//end dev

$headers = [
  "Authorization: OAuth " . $sf_access_data["access_token"],
  "Content-Type: application/json",
];

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$json_response = curl_exec($curl);
unset($curl);

echo json_encode($json_response);

?>
