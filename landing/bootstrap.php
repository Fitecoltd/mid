<?php

function debug()
{
    //        return true; /// Test mode
    return isset($_REQUEST['debug']);
}

function test()
{
    //        return true; /// Test mode
    return isset($_REQUEST['test']);
}


function send_to_keitaro($postData)
{
    $keitaroPostbackUrl = 'https://keistream.com/3c218da/postback';

    $ch = curl_init($keitaroPostbackUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    if (!test()) {
        $response = curl_exec($ch);
    }
    curl_close($ch);
}

