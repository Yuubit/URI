<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 2:54 PM
 */

namespace Yuubit\URI\Internal;


use Nette\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;
use Yuubit\URI\Part;

class URITokenizerTest extends TestCase
{
    const URI = "http://yuubit.de/./simple/path?a=5#somewhere";
    const MULTI_QUERY = "https://yuubit.de/./simple/path?a=5&b=6#somewhere";

    /**
     * @var URITokenizer
     */
    private $tokenizer;

    protected function setUp()
    {
        $this->tokenizer = new URITokenizer();
    }

    function testTokenize() {
        $tokens = $this->tokenizer->tokenizeURI(self::URI);

        self::assertEquals($tokens[(string) Part::SCHEME], "http:");
        self::assertEquals($tokens[(string) Part::AUTHORITY], "//yuubit.de");
        self::assertEquals($tokens[(string) Part::PATH], "/./simple/path");
        self::assertEquals($tokens[(string) Part::QUERY], "?a=5");
        self::assertEquals($tokens[(string) Part::FRAGMENT], "#somewhere");
    }

    function testMultiQuery() {
        $tokens = $this->tokenizer->tokenizeURI(self::MULTI_QUERY);

        self::assertEquals($tokens[(string) Part::SCHEME], "https:");
        self::assertEquals($tokens[(string) Part::AUTHORITY], "//yuubit.de");
        self::assertEquals($tokens[(string) Part::PATH], "/./simple/path");
        self::assertEquals($tokens[(string) Part::QUERY], "?a=5&b=6");
        self::assertEquals($tokens[(string) Part::FRAGMENT], "#somewhere");
    }
}