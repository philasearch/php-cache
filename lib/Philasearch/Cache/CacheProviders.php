<?php

/**
 * CacheProviders.php
 *
 * @author      Thomas Muntanerd
 * @version     1.0.0
 */

namespace Philasearch\Cache;

use MyCLabs\Enum\Enum;

/**
 * Class CacheProviders
 *
 * Enum for selecting cache provider
 *
 * @package Philasearch\Cache
 *
 */
class CacheProviders extends Enum
{
    const REDIS = 1;
}
