<?php

/**
 * ObjectType.php
 *
 * @author      Thomas Muntaner
 * @version     1.0.0
 */

namespace Philasearch\Cache;

use MyCLabs\Enum\Enum;

class ObjectType extends Enum
{
    const OBJECT    = 1;
    const TREE      = 2;
}