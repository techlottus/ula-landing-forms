<?php
echo "prueba de echo 1";

require __DIR__ . '/vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/')->load();

// echo getenv('APP_ENV');
// echo $_ENV['APP_NAME'];

// Figure out the requested page; fallback to the home page.
$GRANT_TYPE = $_GET["GRANT_TYPE"] ?? "tavacio";
$CLIENT_ID = $_GET["CLIENT_ID"] ?? "tavacio";
$CLIENT_SECRET = $_GET["CLIENT_SECRET"] ?? "tavacio";
$USERNAME = $_GET["USERNAME"] ?? "tavacio";
$PASSWORD = $_GET["PASSWORD"] ?? "tavacio";



echo "prueba de echo 2";
// echo $_SERVER["GRANT_TYPE"]
// echo getenv("GRANT_TYPE")
echo "hola mundo";
echo $GRANT_TYPE
echo $CLIENT_ID
echo $CLIENT_SECRET
echo $USERNAME
echo $PASSWORD
	?>