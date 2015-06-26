<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Test;

use PHPUnit_Framework_TestCase as TestCase;
use OldTown\PropertySet\PropertySetManager;

/**
 * Class PropertySetManagerTest
 *
 * @package OldTown\PropertySet\Test
 */
class PropertySetManagerTest extends TestCase
{
    /**
     * Проверка того что загружается PropertySetManager
     *
     * @return void
     */
    public function testCreatePropertySetManage()
    {
        $manager = new PropertySetManager();
        static::assertInstanceOf(PropertySetManager::class, $manager);
    }
}
