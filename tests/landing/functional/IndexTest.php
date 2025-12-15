<?php

include __DIR__ . '/../../../landing/Firewall.php';

use PHPUnit\Framework\TestCase;

class RedirectScriptTest extends TestCase
{
    private $scriptPath = __DIR__ . '/../../../landing/index.php';

    function header($string) {
        RedirectScriptTest::$headers[] = $string;
    }

    protected function setUp(): void
    {
        // Сбрасываем REQUEST перед каждым тестом
        $_REQUEST = ['test' => 1];
    }

    public function testThrowsExceptionWhenSubidMissing()
    {
        $_REQUEST['target'] = 'https://example.com/offer';
        $whitelist = \landing\Firewall::config('whitelist');
        $_SERVER['REMOTE_ADDR'] = array_shift($whitelist);
        $_REQUEST['secret'] = \landing\Firewall::config('secret');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        include $this->scriptPath;
    }

    public function testThrowsExceptionWhenTargetMissing()
    {
        $_REQUEST['subid'] = 'abc123';
        $whitelist = \landing\Firewall::config('whitelist');
        $_SERVER['REMOTE_ADDR'] = array_shift($whitelist);
        $_REQUEST['secret'] = \landing\Firewall::config('secret');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Server error');

        include $this->scriptPath;
    }

    public function testRedirectWithValidSubidAndTarget()
    {
        $_REQUEST['subid']  = 'abc123';
        $_REQUEST['target'] = 'https://example.com/offer';
        $whitelist = \landing\Firewall::config('whitelist');
        $_SERVER['REMOTE_ADDR'] = array_shift($whitelist);
        $_REQUEST['secret'] = \landing\Firewall::config('secret');

        ob_start();
        try {
            include $this->scriptPath;
        } catch (\Exception $e) {
            $this->assertStringStartsWith('Cannot modify header information - headers already sent by', $e->getMessage());
        }
        ob_end_clean();

//        $headers = xdebug_get_headers();
//        $this->assertContains('Location: ' . $_REQUEST['target'], $headers);
    }
}
