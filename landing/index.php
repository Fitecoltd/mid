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

if (!empty($queryParams['broker'])) {
    $postData['sub_id_30'] = json_encode(['broker' => $queryParams['broker']]);
}

send_to_keitaro($queryParams);


unset($queryParams['target']); // чтобы не дублировать target в строке

// Редиректим пользователя на целевой URL с параметрами
$redirector = new Redirector();
return $redirector->redirect($_GET['target'], $queryParams);
