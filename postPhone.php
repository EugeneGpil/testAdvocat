<?php

if (isset($_POST)){

    //get Api key=======================================================
    $url = 'http://alfashops.ru/scripts/test_task/api_sample.php';
    $data = ['method' => 'get_api_key'];

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $apiKey = file_get_contents($url, false, $context);
    //=========================================================================


    //post phone================================================================
    if  ($_POST['name'] == '' or $_POST['phone'] == '' or $_SERVER['REMOTE_ADDR'] == ''
            or $apiKey == ''){
                echo 'error';
                return;
            }


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, 'http://alfashops.ru/scripts/test_task/api_sample.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $postData = 'method=send_lead' . 
        '&name=' . $_POST['name'] . 
        '&phone=' . $_POST['phone'] .
        '&ip=' . $_SERVER['REMOTE_ADDR'] . 
        '&key=' . $apiKey;

    echo $postData;

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $postPhoneRes = curl_exec($ch);
    curl_close($ch);

    //==========================================================================

    var_dump($postPhoneRes);
}