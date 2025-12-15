<?php

namespace landing;

class Firewall
{
    private static $config;

    public static function config($key, $default = null)
    {
        if (!self::$config) {
            self::$config = require_once 'config/firewall.php';
        }

        return self::$config[$key] ?? $default;
    }

    public static function filter($input)
    {
        if (!in_array(strtolower($_SERVER['REMOTE_ADDR']), self::config('whitelist', []), true)) {
            throw new \Exception('Forbidden');
        }

        $incomingSecret = $input['secret'] ?? $input['sub_id_1'] ?? null;

        if ($incomingSecret !== self::config('secret')) {
            throw new \Exception('Invalid secret');
        }

        return true; // фильтр пройден
    }
}

