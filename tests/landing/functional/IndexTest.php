<?php
use PHPUnit\Framework\TestCase;

class RedirectScriptTest extends TestCase
{
    private $scriptPath = __DIR__ . '/../redirect.php';

    protected function setUp(): void
    {
        // Сбрасываем REQUEST перед каждым тестом
        $_REQUEST = [];
    }

    public function testThrowsExceptionWhenSubidMissing()
    {
        $_REQUEST['target'] = 'https://example.com/offer';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        include $this->scriptPath;
    }

    public function testThrowsExceptionWhenTargetMissing()
    {
        $_REQUEST['subid'] = 'abc123';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        include $this->scriptPath;
    }

    public function testRedirectWithValidSubidAndTarget()
    {
        $_REQUEST['subid']  = 'abc123';
        $_REQUEST['target'] = 'https://example.com/offer';

        // Перехватываем заголовки
        ob_start();
        try {
            include $this->scriptPath;
        } catch (\Exception $e) {
            // Игнорируем exit
        }
        ob_end_clean();

        $headers = xdebug_get_headers();
        $this->assertContains('Location: https://example.com/offer', $headers);
    }
}
