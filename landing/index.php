<?php

$queryParams = $_GET;

if (empty($queryParams['aff_sub']) || empty($queryParams['target'])) {
    throw new \Exception('Server error');
}


require_once 'bootstrap.php';
require_once 'Redirector.php';



send_to_keitaro($queryParams['aff_sub']);



unset($queryParams['target']); // чтобы не дублировать target в строке

// Редиректим пользователя на целевой URL с параметрами
$redirector = new Redirector();
return $redirector->redirect($_GET['target'], $queryParams);
