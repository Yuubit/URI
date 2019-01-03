<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 1:01 PM
 */

namespace Yuubit\URI\Exception;


use Throwable;

class MalformedException extends \Exception
{
    public function __construct(string $uri)
    {
        parent::__construct("Malformed URI: $uri");
    }

}