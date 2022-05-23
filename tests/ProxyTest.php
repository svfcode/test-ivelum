<?php

use PHPUnit\Framework\TestCase;
use App\Proxy;


final class ProxyTest extends TestCase {

    public $pageMock = '<html lang="en"><title>Profile: jessegrosjean | Hacker News</title><a href="submit">submit</a><script type="text/javascript" src="hn.js?F2tdhQa6ArfaD03Cf9Jc"></script></html>';

    public function test_add_tm() {
        $proxy = new Proxy();

        $handledPage = $proxy->add_tm($this->pageMock);

        $this->assertTrue(str_contains($handledPage, 'Hacker&trade;'));
    }
}
