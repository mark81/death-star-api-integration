<?php

ini_set('display_errors', 'yes');
error_reporting(255);
require("bootstrap.php");

use App\DeathStar\DeathStarClient;
use App\DeathStar\Exhaust;
use App\DeathStar\Prisoner;

$opts = [
    'ssl_key' => env('SSL_KEY_PATH'),
    'api_uri' => env('API_URL'),
    'client_secret' => env('CLIENT_SECRET'),
    'client_id' => env('CLIENT_ID'),
    'scope' => 'TheForce'
];
$client = DeathStarClient::fromConfigArray($opts);

//throw thorpedos on reactor
$exhaust = new Exhaust($client);
$exhaust->delete(1);

//fetch leia
$leia = new Prisoner($client);
$leia->get('leia');

