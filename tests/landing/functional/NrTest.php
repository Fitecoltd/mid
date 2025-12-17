<?php

use PHPUnit\Framework\TestCase;

class NrTest extends TestCase
{
    private $scriptPath = __DIR__ . '/../../../landing/index.php';

    protected function setUp(): void
    {
        // Сбрасываем REQUEST перед каждым тестом
        $_REQUEST['test']= 1;
    }

    public function build_get_from_query($query) {

        parse_str($query, $queryParams);

        $_GET = $queryParams;
    }

    public function testFirst()
    {
        $baseUrl = "https://t.testt2.tes/295910/8760/39350";
        $params = "aff_sub3=TC_HHB5S378&aff_sub5=SF_006OG00000GJUxH&aff_sub=234fsd34";
        $this->build_get_from_query($params . '&target=' . $baseUrl);

        $headers = include $this->scriptPath;

        $this->assertEquals($baseUrl . '?' . $params, $headers);
    }
}
