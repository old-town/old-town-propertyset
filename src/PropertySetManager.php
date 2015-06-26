<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;
use OldTown\PropertySet\Config\PropertySetConfig;
use OldTown\PropertySet\Exception\RuntimeException;
use ReflectionClass;

/**
 * Class PropertySetManager
 *
 * @package OldTown\PropertySet
 */
class PropertySetManager
{
    /**
     * @param       $name
     * @param array $args
     *
     * @return PropertySetInterface
     *
     * @throws \OldTown\PropertySet\Exception\RuntimeException
     */
    public static function getInstance($name, array $args = [])
    {
        $psc = PropertySetConfig::getConfig();
        $class = $psc->getClassName($name);

        if (null === $class || !class_exists($class)) {
            return null;
        }

        $config = $psc->getArgs($name);

        try {
            $r = new ReflectionClass($class);
            $ps = $r->newInstance();

            if (!$ps instanceof PropertySetInterface) {
                $errMsg = sprintf(
                    'Объект должен реализовывать интерфейс %s',
                    PropertySetInterface::class
                );
                throw new RuntimeException($errMsg);
            }

            $ps->init($config, $args);

            return $ps;
        } catch (\Exception $e) {
            $errMsg = sprintf(
                'Ошибка при создание сервиса  %s',
                $name
            );
            throw new RuntimeException($errMsg);
        }

    }
}
