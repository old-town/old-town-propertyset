<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Test;

use PHPUnit_Framework_TestCase as TestCase;
use OldTown\PropertySet\PropertySetManager;
use OldTown\PropertySet\Providers\Memory\MemoryPropertySet;

/**
 * Class PropertySetManagerTest
 *
 * @package OldTown\PropertySet\Test
 */
class PropertySetManagerTest extends TestCase
{
    /**
     * Создание PropertySet
     *
     * @return void
     */
    public function testCreatePropertySetMemory()
    {
        $pr = PropertySetManager::getInstance('memory', []);

        static::assertInstanceOf(MemoryPropertySet::class, $pr);

    }
}
