<?php

include Firewall;

function debug()
{
    //        return true; /// Test mode
    return isset($_REQUEST['debug']);
}

try {
    \landing\Firewall::filter($_REQUEST);
} catch (\Throwable $e) {
    if (debug()) {
        echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        exit();
    } else {
        throw new \Exception($e->getMessage());
    }
}

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
    $response = curl_exec($ch);
    curl_close($ch);

    // Для отладки можно логировать ответ
    // file_put_contents("postback.log", date("c")." ".$response."\n", FILE_APPEND);
}

// Редиректим пользователя на целевой URL
header("Location: $targetUrl");
