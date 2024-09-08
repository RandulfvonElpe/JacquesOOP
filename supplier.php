<?php

include('./template/navbar.php');
include('config.php');

function CallAPI($method, $url, $data)
{
    $curl = curl_init();
/*
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
*/
//    Optional Authentication:
//    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 //   curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

include('./template/footer.php'); 
 ?>

<div class="m-3">
    <h1>Abfrage über die API / Supplier</h1> 

    <?php
        $result = CallAPI('GET', 'http://localhost/JacquesOOP/api.php/', '');
 //       $obj = json_encode($result);
        echo($result);
    ?>
    
</div>