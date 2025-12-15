<?php

require_once 'Firewall.php';
require_once 'bootstrap.php';

if (empty($_REQUEST['subid']) || empty($_REQUEST['target'])) {
    throw new \Exception('Server error');
}
$subid     = $_REQUEST['subid'];
$targetUrl = $_REQUEST['target'];
$keitaroPostbackUrl = 'https://keistream.com/3c218da/postback';

if ($subid) {
    $postData = [
        'subid'  => $subid,
        'status' => 'conversion', // можно указать custom статус
        'payout' => 0,
    ];

    $ch = curl_init($keitaroPostbackUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    if (!test()) {
        $response = curl_exec($ch);
    }
    curl_close($ch);

    // Для отладки можно логировать ответ
    // file_put_contents("postback.log", date("c")." ".$response."\n", FILE_APPEND);
}

// Редиректим пользователя на целевой URL
header("Location: $targetUrl");
