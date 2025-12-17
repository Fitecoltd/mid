<?php

class Redirector
{
    public function redirect(string $url, array $queryParams): string
    {
        $queryString = http_build_query($queryParams);

        // Формируем финальный URL
        $redirectUrl = $url;
        if ($queryString) {
            $redirectUrl .= (strpos($url, '?') === false ? '?' : '&') . $queryString;
        }

        if (test()) {
            // В тестах просто возвращаем URL
            return $redirectUrl;
        }

        header("Location: $redirectUrl");
        exit;
    }
}
