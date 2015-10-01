[![Latest Stable Version](https://poser.pugx.org/philasearch/cache/version.svg)](https://packagist.org/packages/philasearch/cache)
[![Total Downloads](https://poser.pugx.org/philasearch/cache/downloads.svg)](https://packagist.org/packages/philasearch/cache)
[![Build Status](https://travis-ci.org/philasearch/php-cache.png?branch=master)](https://travis-ci.org/philasearch/php-cache)

# PHP Cache

PHP Cache is a simple caching library for HTML and objects.

## Installing

Add the following to your composer.json

```json
{
    "require": {
        "philasearch/cache": "~1.1.0"
    }
}
```

## Setup

**Notice:** *Currently, only a redis cache is supported.*

```php
<?php

use Philasearch\Cache\Cache;
use Philasearch\Cache\CacheProviders;

Cache::setup(
    CacheProviders::REDIS,
    [
        'scheme'    => 'tcp',
        'host'      => 'localhost',
        'database'  => 0
    ]
);
```

## Using Cached Objects

### Creating an Object

#### Method 1: Using CachedObject

```php
<?php

use Philasearch\Cache\Objects\CachedObject;

$object = new CachedObject('cache_key');
```

#### Method 2: Extending CachedObject

```php
<?php

use Philasearch\Cache\Objects\CachedObject;

class Extended extends CachedObject
{
    public function __construct($key, array $opts=[])
    {
        parent::__construct($key, $opts);
    }
}

$object = new Extended('foo');
```

### Variables
```php
<?php

use Philasearch\Cache\Objects\CachedObject;

$object = new CachedObject('cache_key');

# fill method
$object->fill(['foo' => 'bar']);

# set methods
$object->set('foo', 'bar');

# get methods
$foo = $object->get('foo');
```

### Namespaces

To prevent overwriting of data with multiple objects, you can namespace your objects.  Namespacing will make your cache key
`namespace:cache_key` instead of just `cache_key`.

#### Method 1: Adding the Namespace to the Object During Creation

```php
<?php

use Philasearch\Cache\Objects\CachedObject;

$object = new CachedObject('cache_key', ['namespace' => 'foo']);
```

#### Method 2: Adding the Namespace to a Class Extending CachedObject

```php
<?php

use Philasearch\Cache\Objects\CachedObject;

class NamespaceClass extends CachedObject
{
    protected $namespace = 'foo';

    public function __construct($key, array $opts=[])
    {
        parent::__construct($key, $opts);
    }
}

$object = new NamespaceClass('cache_key');
```

## Using Trees

### Creating a Tree

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');
```

### Making a Root Node

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');

$root = $tree->makeRootNode(1);

# You can also pass data to the root node during creation
$root = $tree->makeRootNode(1, ['foo' => 'bar']);
```

### Passing Data to a node

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');

$root = $tree->makeRootNode(1);

$root->foo = 'bar';
```

### Adding a Child to the Root Node

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');

$root = $tree->makeRootNode(1);

# Make the new node with its id as its argument
$node = $root->addChild(2)

# You can also pass data to the node during creation
$node = $root->addChild(2, ['foo' => 'bar']);
```

### Saving the Tree

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');
$root = $tree->makeRootNode(1);
$node = $root->addChild(2)

$tree->save();
```

### Getting the Data from the Tree

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');
$root = $tree->makeRootNode(1);
$node = $root->addChild(2)

$tree->save();

# Starting from the root node
$tree->getData();

# Starting from a set node (by ID)
$tree->getData(1);
```

### Retrieving a Tree

A tree that has been saved can also be retrieved at a later point with the tree'S cache key

```php
<?php

use Philasearch\Cache\Objects\CachedTree;

$tree = new CachedTree('cached_key');
$root = $tree->makeRootNode(1);
$node = $root->addChild(2)

$tree->save();

$tree = new Tree('cached_key');
```
