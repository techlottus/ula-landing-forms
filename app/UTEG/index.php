<?php

header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');
// header('Access-Control-Allow-Methods: "GET, PUT, POST, DELETE, HEAD, OPTIONS"');

// add_action( 'rest_api_init', function () {
//   register_rest_route('wp', '/json', array(
//     'methods' => 'GET',
//     'callback' => 'get_programa_online_presencial',
//   ) );
// } );

//Función Callback
function get_programa_online_presencial( ) {
 /**
 * Global vars
 * TODO: Move to a safe route
 */
    $urlAccessToken    = 'https://lottus.my.salesforce.com/services/oauth2/token?client_id=3MVG9LBJLApeX_PAaOZZnyLX4MdUEQQ3Uvh67OB.CUsoBo5VPlhI7Y92gdagNcjsXblunkDI18KLBA6nY2tL7&client_secret=011D2286679B186BFB5928E679F069E9E9F81ACDFCE7CE3F713D65CD713B8309&username=uteg_integracion@lottuseducation.com&password=UTEGLottus@2025*8wD43kfW37dzrU77XJ10NUjEi&grant_type=password';
    $urlCourseOffering = 'https://lottus.my.salesforce.com/services/apexrest/hed__Course_Offering__c?linea=ULA';
    $urlCourseOfferingUTEG = 'https://lottus.my.salesforce.com/services/apexrest/hed__Course_Offering__c?linea=UTEG';
    $urlCourseOfferingUANE = 'https://lottus.my.salesforce.com/services/apexrest/hed__Course_Offering__c?linea=UANE';
    $grantType         = 'password';
    $clientId          = '3MVG9LBJLApeX_PAaOZZnyLX4MdUEQQ3Uvh67OB.CUsoBo5VPlhI7Y92gdagNcjsXblunkDI18KLBA6nY2tL7';
    $clientSecret      = '011D2286679B186BFB5928E679F069E9E9F81ACDFCE7CE3F713D65CD713B8309';
    $username          = 'uteg_integracion@lottuseducation.com';
    $password          = 'UTEGLottus@2025*8wD43kfW37dzrU77XJ10NUjEi';

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

    if($access === false) {
        // ERROR MSG
        // $e = error_get_last();
        // echo "error: " . $e["message"];
        echo "Error: No se pudo consultar la oferta académica en estos momentos (1)";
    } else {
        $token = json_decode($access);
        // Offering request
        $options = [
            'http' => [
                'header' => "Authorization: {$token->token_type} {$token->access_token}\r\n",
                'method' => 'GET'
            ]
        ];
        $context  = stream_context_create($options);
        $offering =  file_get_contents($urlCourseOffering, false, $context);
        $offeringUTEG =  file_get_contents($urlCourseOfferingUTEG, false, $context);
        $offeringUANE =  file_get_contents($urlCourseOfferingUANE, false, $context);
        if($offering === false && $offeringUTEG  === false) {
            // ERROR MSG
            // $e = error_get_last();
            // echo "error: " . $e["message"];
            echo "Error: No se pudo consultar la oferta académica en estos momentos (2)";
        } else {
            //$offering =  json_decode($offering);
            // Example
            //  echo "<pre>";
            //  var_dump($offering);
            //  echo "</pre>";
                echo json_encode(array_merge(json_decode($offering, true),json_decode($offeringUTEG, true),json_decode($offeringUANE, true)),\JSON_UNESCAPED_UNICODE);
        }
    }
}
get_programa_online_presencial()
?> 
