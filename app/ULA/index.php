<?php

extract($_POST);
if ($tk == "ptk" && $_POST) {
  function get_sf_auth_data()
  {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    $post_data = [
      "grant_type" => "password",
      "client_id" =>
        "3MVG9LBJLApeX_PAaOZZnyLX4MUk3xLx9_tc9QDO9xB_g7thRcTG7sw3HPTZUcSWTxKyxB03VLHic5LTRYk5J",
      "client_secret" =>
        "3A9F43D6F2D7C7D67E257BAED415F90A26476EC1E5A6A76BA47EDF3BD9159DB9",
      "username" => "ula_integracion@lottuseducation.com",
      "password" => "Lottus@CRM2025ULADqaWBga3iHQeBuO3MBRlO0Fg",
    ];

    $headers = [
      "Content-type" => "application/x-www-form-urlencoded;charset=UTF-8",
    ];

    $curl = curl_init("https://lottus.my.salesforce.com/services/oauth2/token");

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

    $response = curl_exec($curl);
    unset($curl);

    $sf_access_data = json_decode($response, true);

    return $sf_access_data;
  }

  $sf_access_data = get_sf_auth_data();
  $instance_url = $sf_access_data["instance_url"];
  $url = "$instance_url/services/apexrest/hed__Course_Offering__c?linea=ULA";

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

  $datos = [];
  $datos2 = [];
  $dat = json_decode($json_response, true);

  for ($i = 0; $i < count($dat); $i++) {
    $datos[] = $dat[$i];
  }

  for ($i = 0; $i < count($dat); $i++) {
    if (
      $datos[$i]["nombreCampus"] != "UTEG ONLINE" &&
      $datos[$i]["nombreCampus"] != "MONTERREY" &&
      $datos[$i]["nombreCampus"] != "SALTILLO" &&
      $datos[$i]["nombreCampus"] != "SALTILLO" &&
      $datos[$i]["nombreCampus"] != "AMERICAS" &&
      $datos[$i]["nombreCampus"] != "CAMPUS" &&
      $datos[$i]["nombreCampus"] != "CAMPUS ZAPOPAN" &&
      $datos[$i]["nombreCampus"] != "UTEG BY ULA" &&
      $datos[$i]["nombreCampus"] != "TLAJOMULCO" &&
      $datos[$i]["nombreCampus"] != "TORREÓN" &&
      $datos[$i]["nombreCampus"] != "MATAMOROS" &&
      $datos[$i]["nombreCampus"] != "PIEDRAS NEGRAS" &&
      $datos[$i]["nombreCampus"] != "LAZARO CARDENAS" &&
      $datos[$i]["nombreCampus"] != "OLIMPICA" &&
      $datos[$i]["nombreCampus"] != "RIO NILO" &&
      $datos[$i]["nombreCampus"] != "UANE ONLINE" &&
      $datos[$i]["nombreCampus"] != "REYNOSA" &&
      $datos[$i]["nombreCampus"] != "SABINAS" &&
      $datos[$i]["nombreCampus"] != "PEDRO MORENO" &&
      $datos[$i]["nombreCampus"] != "MONCLOVA"
    ) {
      $datos2[] = $datos[$i];
    }
  }

  echo json_encode($datos2);
} else {
  echo "acceso denegado";
}
?>
