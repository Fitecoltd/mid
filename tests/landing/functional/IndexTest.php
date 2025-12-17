<?php

use PHPUnit\Framework\TestCase;

class RedirectScriptTest extends TestCase
{
    private $scriptPath = __DIR__ . '/../../../landing/index.php';

    protected function setUp(): void
    {
        // Сбрасываем REQUEST перед каждым тестом
        $_REQUEST['test']= 1;
    }

    public function testThrowsExceptionWhenSubidMissing()
    {
        $_GET = ['target' => 'https://example.com/offer'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        include $this->scriptPath;

    }

    public function testThrowsExceptionWhenTargetMissing()
    {
        $_GET = ['aff_sub' => 'abc123'];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        $res = include $this->scriptPath;

    }

    public function testRedirectWithValidSubidAndTarget()
    {
        $_GET = [
            'aff_sub'  => 'abc123',
            'target' => 'https://example.com/offer',
        ];

        $headers = include $this->scriptPath;

        $this->assertEquals('https://example.com/offer?aff_sub=abc123', $headers);
    }
}
