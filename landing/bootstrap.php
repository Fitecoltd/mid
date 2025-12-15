<?php

require_once 'Firewall.php';

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
