<?php

$CURLOPT_URL = "http://localhost/api/DSC/api/view";
$response = json_decode($CURLOPT_URL);

foreach ($response as $key) {
    echo $response['name'].'<br>';
}


?>