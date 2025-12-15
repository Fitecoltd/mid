
<?php
// tests/bootstrap.php
define('SINGLETON', true);


if (!isset($_SERVER['REMOTE_ADDR'])) {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}

require __DIR__ . '/../vendor/autoload.php';
