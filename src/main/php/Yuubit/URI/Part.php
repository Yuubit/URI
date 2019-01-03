<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 1/2/19
 * Time: 2:43 PM
 */

namespace Yuubit\URI;


use MyCLabs\Enum\Enum;

class Part extends Enum
{
    const SCHEME = "scheme";
    const AUTHORITY = "authority";
    const PATH = "path";
    const QUERY = "query";
    const FRAGMENT = "fragment";
}