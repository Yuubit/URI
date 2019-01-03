<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 2:37 PM
 */

namespace Yuubit\URI\Internal;


use Yuubit\Tokenizer\Tokenizer;
use Yuubit\URI\Part;
use Yuubit\URI\Regex;
use Yuubit\URI\URI;

class URITokenizer
{
    /**
     * @var Tokenizer
     */
    private $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new Tokenizer([
            (string) Part::SCHEME() => Regex::SCHEME,
            (string) Part::AUTHORITY() => Regex::AUTHORITY,
            (string) Part::PATH() => Regex::PATH,
            (string) Part::QUERY() => Regex::QUERY,
            (string) Part::FRAGMENT() => Regex::FRAGMENT
        ]);
    }

    /**
     * @param $uri
     * @return string[]
     */
    function tokenizeURI($uri) {
        $stream = $this->tokenizer->tokenize($uri);
        $tokens = [];

        while($token = $stream->nextToken()) {
            $tokens[$token->getType()] = $token->getValue();
        }

        return $tokens;
    }
}