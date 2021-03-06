<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 12:10 PM
 */

namespace Yuubit\URI;


use Yuubit\Tokenizer\IStream;
use Yuubit\URI\Exception\MalformedException;
use Yuubit\URI\Exception\UnknownSchemeException;
use Yuubit\URI\Internal\URITokenizer;

class URI
{
    // parts of a URI

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $authority;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $fragment;

    /**
     * URI constructor.
     * @param string $scheme
     * @param string $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    private function __construct(
        string $scheme = "",
        string $authority = "",
        string $path = "",
        string $query = "",
        string $fragment = ""
    )
    {
        $this->scheme = $scheme;
        $this->authority = $authority;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
        $this->tokenizer = new URITokenizer();
    }

    /**
     * @param string $uri
     * @return URI
     * @throws MalformedException
     * @throws UnknownSchemeException
     */
    static function fromString(string $uri): URI
    {
        $tokens = (new URITokenizer())->tokenizeURI($uri);

        return new URI(
            isset($tokens[(string)Part::SCHEME]) ? $tokens[(string)Part::SCHEME] : "",
            isset($tokens[(string)Part::AUTHORITY]) ? $tokens[(string)Part::AUTHORITY] : "",
            isset($tokens[(string)Part::PATH]) ? $tokens[(string)Part::PATH] : "",
            isset($tokens[(string)Part::QUERY]) ? $tokens[(string)Part::QUERY] : "",
            isset($tokens[(string)Part::FRAGMENT]) ? $tokens[(string)Part::FRAGMENT] : ""
        );
    }

    /**
     * Removes unnecessary parts from the uri as well as it corrects Capping.
     * @return URI
     */
    function normalize(): URI
    {
        return new URI(
            strtolower($this->scheme),
            strtolower($this->authority),
            strtolower(preg_replace("/" . Regex::REPLACABLES . "/", "/", $this->path)),
            strtolower($this->query),
            strtolower($this->fragment)
        );
    }

    /**
     * Resolves a URI based on the original.
     * @param string $uri
     * @return URI
     */
    function resolve(string $uri): URI
    {
        if (strpos($uri, "//") === 0 || strpos($uri, "/") === 0) {
            return $this->resolvePath($uri);
        } else if (strpos($uri, "#") === 0) {
            return $this->resolveFragment($uri);
        } else {
            return $this->resolvePathRelative($uri);
        }
    }

    /**
     * Asserts for Equality.
     * @param URI $uri
     * @return bool
     */
    function equals(URI $uri): bool
    {
        return (string)$this->normalize() === (string)$uri->normalize();
    }

    private function resolvePath(string $path): URI
    {
        return self::fromString(
            $this->scheme . $this->authority . $path
        )->normalize();
    }

    private function resolveFragment(string $path): URI
    {
        return (new URI(
            $this->scheme,
            $this->authority,
            $this->path,
            $this->query,
            $path
        ))->normalize();
    }

    private function resolvePathRelative(string $path): URI
    {
        return (new URI(
            $this->scheme,
            $this->authority,
            $this->path . Regex::PATH_SEPERATOR . $path
        ))->normalize();
    }

    public function __toString()
    {
        return $this->scheme .
            $this->authority .
            $this->path .
            $this->query .
            $this->fragment;
    }

}