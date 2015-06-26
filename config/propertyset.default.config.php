<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Config;

use OldTown\PropertySet\Providers\Memory\MemoryPropertySet;

return [
    'memory' => [
        'class' => MemoryPropertySet::class,
        'args' => []
    ]
];