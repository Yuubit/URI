<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 12:34 PM
 */

namespace Yuubit\URI;


use PHPUnit\Framework\TestCase;

class URITest extends TestCase
{
    const URI_0 = "http://easy.com/simple/path";
    const URI_1 = "HTTP://easy.com/./simple/path";
    const ABSOLUTE = "/another/path";
    const RELATIVE = "go/there";

    const FILE = "file:///etc/somefile";

    /**
     * @var URI
     */
    private $uri0;

    /**
     * @var URI
     */
    private $uri1;

    protected function setUp()
    {
        $this->uri0 = URI::fromString(self::URI_0);
        $this->uri1 = URI::fromString(self::URI_1);
    }

    function testNormalize() {
        $uri = $this->uri1->normalize();
        self::assertEquals(self::URI_0, (string) $uri);
    }

    function testEquals() {
        self::assertTrue($this->uri0->equals($this->uri0));
        self::assertTrue($this->uri0->equals($this->uri1));
    }

    function testResolve() {
        $absoluteUri = $this->uri0->resolve(self::ABSOLUTE);
        self::assertEquals(URI::fromString("http://easy.com/another/path"), $absoluteUri);

        $relativeUri = $this->uri0->resolve(self::RELATIVE);
        self::assertEquals(URI::fromString("http://easy.com/simple/path/go/there"), $relativeUri);
    }

    function testFile() {
        $uri = URI::fromString(self::FILE);
        $expectedRelative = URI::fromString("file:///etc");

        self::assertEquals($uri->resolve(".."), $expectedRelative);

        $expectedRelative = URI::fromString("file:///etc/anotherFile");
        self::assertEquals($uri->resolve("../anotherFile"), $expectedRelative);
    }
}