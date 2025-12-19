<?php

$queryParams = $_GET;

if (empty($queryParams['aff_sub']) || empty($queryParams['target'])) {
    throw new \Exception('Server error');
}


require_once 'bootstrap.php';
require_once 'Redirector.php';


$postData = [
    'subid' => $queryParams['aff_sub'],
    'sub_id_14' => 1,
    'goal_id' => 1,
];

 send_to_keitaro($postData); // Убрано, чтобы избежать дублей

unset($queryParams['target']); // чтобы не дублировать target в строке

// Редиректим пользователя на целевой URL с параметрами
$redirector = new Redirector();
return $redirector->redirect($_GET['target'], $queryParams);
