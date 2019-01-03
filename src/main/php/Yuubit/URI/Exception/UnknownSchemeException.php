<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 1:12 PM
 */

namespace Yuubit\URI\Exception;


use Throwable;

class UnknownSchemeException extends \Exception
{
    public function __construct(string $scheme)
    {
        parent::__construct("Unknown Scheme: $scheme");
    }

}