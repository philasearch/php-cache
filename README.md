[![Build Status](https://travis-ci.org/rubyrainbows/php-cache.png?branch=master)](https://travis-ci.org/rubyrainbows/php-cache)

# PHP Cache

PHP Cache is a simple caching library for HTML and objects.

## Installing

Add the following to your composer.json

```json
{
    "repositories": [
        {
            "url": "https://github.com/rubyrainbows/php-cache.git",
            "type": "vcs"
        }
    ],
    "require": {
        "RubyRainbows/cache": "@dev"
    }
}
```

## Using

### Setup

**Notice:** *Currently, only a redis cache is supported.*

```php
<?php

using RubyRainbows\Cache;

Cache::setup(
    Cache::REDIS_CACHE,
    [
        'scheme'    => 'tcp',
        'host'      => 'localhost',
        'database'  => 0
    ]
);
```

### Cached Objects

```php
<?php

using RubyRainbows\Cache;

# cache setup

# make a cached object with no data
$object = Cache::object('cache_key');

# make a cached object with data
$object = Cache::object('cache_key', ['field' => 'value']);

# getting a value from a cached object
$field = $object->field;

# setting a value to a field
$object->random_field = "foo";

# deleting a field from a cached object
$object->delete('random_field');

$deleting all fields from a cached object
$object->deleteAll();

# A cached object can be retrieved at any time with its id
$object = Cache::object('cache_key', ['field' => 'value']);
$field  = $object->field;
$object = Cache::object('cache_key');
```

### Trees

```php
<?php

using RubyRainbows\Cache;

# cache setup

# making a tree
$tree = Cache::tree('key');

# creating a root node
#
# This function makeRootNode($id,$data) takes the param of id so that the node can be easily accessed in the future
$root = $tree->makeRootNode(1);

# you can also pass field data to the root as well
$root = $tree->makeRootNode(1, ['field' => 'foo']);

# The root node can add child nodes to itself
#
# This function addChild($id,$data) takes the param of id so that the node can be easily accessed in the future
$root->addChild(2);

# As with the root node, you can also add field data to the node in the addChild() function
$root->addChild(2, ['foo' => 'bar']);

# Saving a tree to the cache
$tree->save();

# Getting the data array from the cache (staring from root node)
$tree->getData();

# You can also get the data array starting from any node by supplying its id to the getData() function
$tree->getData(1);

# A tree that has been saved can also be retrieved at a later point with the tree's key
$tree = Cache::tree('tree');

$root = $tree->makeRootNode(1);
$root->addChild(2, ['foo' => 'bar']);
$tree->save();

$tree = Cache::tree('tree');
```