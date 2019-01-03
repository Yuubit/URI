<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 2:48 PM
 */

namespace Yuubit\URI;


use MyCLabs\Enum\Enum;

class Regex extends Enum
{
    const RESERVED = "[\/?#\[\]@:$&'()*+,;=]";
    const NOT_RESERVED = "\-._\~A-Za-z0-9";

    const URI = self::AUTHORITY_MARKER . "";

    const SCHEME_SEPARATOR = ":";
    const SCHEME = "^[" . self::NOT_RESERVED . "]+" . self::SCHEME_SEPARATOR . "$";

    const AUTHORITY_MARKER = "\/\/";
    const AUTHORITY = "^" . self::AUTHORITY_MARKER . "[" . self::NOT_RESERVED . ":]*$";

    const PATH_SEPERATOR = "/";
    const PATH = "(^\/[" . self::NOT_RESERVED . "]+$)|((^\/[" . self::NOT_RESERVED . "]+)(\/[" . self::NOT_RESERVED . "]+)+$)";

    const QUERY_MARKER = "\?";
    const QUERY = "((^" . self::QUERY_MARKER . "[" . self::NOT_RESERVED . "]+=[" . self::NOT_RESERVED . "]+)(&[" . self::NOT_RESERVED . "]+=[" . self::NOT_RESERVED . "]+)+$)|" .
        "(^" . self::QUERY_MARKER . "[" . self::NOT_RESERVED . "]+=[" . self::NOT_RESERVED . "]+$)";

    const FRAGMENT_MARKER = "#";
    const FRAGMENT = "^" . self::FRAGMENT_MARKER . "[" . self::NOT_RESERVED . "]+$";

    const REPLACABLES = "(\/[" . self::NOT_RESERVED . "]+\/\.\.)|(\/\.(?=\/))|(\/(?=\/))";
}