<?php

require_once 'bootstrap.php';

if (empty($_REQUEST['subid']) || empty($_REQUEST['target'])) {
    throw new \Exception('Server error');
}

$subid     = $_REQUEST['subid'];
$targetUrl = $_REQUEST['target'];
$keitaroPostbackUrl = 'https://keistream.com/3c218da/postback';

if ($subid) {
    $postData = [
        'subid' => $subid,
    ];

    $ch = curl_init($keitaroPostbackUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    if (!function_exists('test') || !test()) {
        $response = curl_exec($ch);
    }
    curl_close($ch);

    // Для отладки можно логировать ответ
    // file_put_contents("postback.log", date("c")." ".$response."\n", FILE_APPEND);
}

// Собираем все GET‑параметры, кроме target
$queryParams = $_GET;
unset($queryParams['target']); // чтобы не дублировать target в строке

$queryString = http_build_query($queryParams);

// Формируем финальный URL
$redirectUrl = $targetUrl;
if ($queryString) {
    $redirectUrl .= (strpos($targetUrl, '?') === false ? '?' : '&') . $queryString;
}

// Редиректим пользователя на целевой URL с параметрами
header("Location: $redirectUrl");
exit;
