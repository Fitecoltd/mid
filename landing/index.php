<?php

$queryParams = $_GET;

if (empty($queryParams['aff_sub']) || empty($queryParams['target'])) {
    throw new \Exception('Server error');
}


require_once 'bootstrap.php';
require_once 'Redirector.php';


$postData = [
    'subid' => $queryParams['aff_sub'],
];

// send_to_keitaro($postData); // Убрано, чтобы избежать дублей

$ts = time();
$capiParams = [
    'secret'    => 'k7QpZ9fL3sV2xA1b',
    'broker'    => 'default',
    'target'    => 'viewcontent',
    'pixel'     => $queryParams['sub_id_28'] ?? '',
    'token'     => $queryParams['sub_id_29'] ?? '',
    'clickId'   => $queryParams['aff_sub'],
    'event_time' => $ts,
    'tid'       => 'vc',
    'event_id'  => 'vc_' . $queryParams['aff_sub'] . '_' . $ts,
    'fbclid'    => $queryParams['external_id'] ?? '',
    'userAgent' => $queryParams['user_agent'] ?? '',
    'domain'    => $queryParams['current_domain'] ?? '',
    'ip'        => $queryParams['ip'] ?? '',
    // 'debug'     => 1,
];
send_to_capi($capiParams);

unset($queryParams['target']); // чтобы не дублировать target в строке

// Редиректим пользователя на целевой URL с параметрами
$redirector = new Redirector();
return $redirector->redirect($_GET['target'], $queryParams);
