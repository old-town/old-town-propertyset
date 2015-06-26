<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;

/**
 * Class PropertySetSchema
 *
 * @package OldTown\PropertySet
 */
class PropertySetSchema
{
    /**
     * @var PropertySchema[]
     */
    protected $propertySchemas = [];

    /**
     * @var bool
     */
    protected $restricted = false;

    /**
     *
     * @param string $key
     *
     * @return PropertySchema[]
     *
     * @throws \OldTown\PropertySet\Exception\PropertyException
     */
    public function getPropertySchema($key)
    {
        $key = (string)$key;
        if (!array_key_exists($key, $this->propertySchemas)) {
            $errMsg = sprintf('Не найдена схема по ключу %s', $key);
            throw new Exception\PropertyException($errMsg);
        }

        return $this->propertySchemas[$key];
    }

    /**
     *
     *
     * @param string $key
     * @param PropertySchema $ps
     *
     * @return $this
     */
    public function setPropertySchema($key, PropertySchema $ps)
    {
        $key = (string)$key;
        if (null !== $ps->getPropertyName()) {
            $ps->setPropertyName($key);
        }
        $this->propertySchemas[$key] = $ps;

        return $this;
    }

    /**
     * @param PropertySchema $ps
     *
     * @return $this
     */
    public function addPropertySchema(PropertySchema $ps)
    {
        $key = (string)$ps->getPropertyName();
        $this->propertySchemas[$key] = $ps;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRestricted()
    {
        return $this->restricted;
    }

    /**
     * @param boolean $restricted
     *
     * @return $this
     */
    public function setRestricted($restricted)
    {
        $this->restricted = (boolean)$restricted;

        return $this;
    }
}
