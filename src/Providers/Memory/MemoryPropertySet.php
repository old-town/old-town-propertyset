<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Providers\Memory;

use \OldTown\PropertySet\AbstractPropertySet;
use OldTown\PropertySet\Exception;


/**
 * Class PropertySetManager
 *
 * @package OldTown\PropertySet
 */
class MemoryPropertySet extends AbstractPropertySet
{
    /**
     * @var ValueEntry[]
     */
    protected $map = [];

    /**
     * @param string|null  $prefix
     * @param integer|null $type
     *
     * @return array
     *
     * @throws Exception\PropertyException
     */
    public function getKeys($prefix = null, $type = null)
    {
        $map = $this->getMap();
        $keys = array_keys($map);

        $result = [];

        foreach ($keys as $key) {
            if (null === $prefix || (is_string($prefix) && strpos($key, $prefix))) {
                if (0 === $type) {
                    $result[$key] = $key;
                } else {
                    $v = $map[$key];

                    if ($type === $v->getType()) {
                        $result[$key] = $key;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return integer
     *
     * @throws Exception\PropertyException
     */
    public function getType($key)
    {
        $map = $this->getMap();
        if (array_key_exists($key, $map)) {
            $type = $map[$key]->getType();
            return $type;
        }
        return 0;
    }

    /**
     * @param string $key
     *
     * @return boolean
     *
     * @throws \OldTown\PropertySet\Exception\PropertyException
     */
    public function exists($key)
    {
        $exists = $this->getType($key) > 0;

        return $exists;
    }

    /**
     * @param string $key
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function remove($key)
    {
        $this->map = [];

        return $this;
    }


    /**
     * @return ValueEntry[]
     */
    protected function getMap()
    {
        return $this->map;
    }



    /**
     * @param integer $type
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    protected function setImpl($type, $key, $value)
    {
        if ($this->exists($key)) {
            $v = $this->getMap()[$key];

            if ($type !== $v->getType()) {
                $errMsg = 'Ошибка с типами';
                throw new Exception\DuplicatePropertyKeyException($errMsg);
            }

            $v->setValue($value);
        } else {
            $valueEntry = new ValueEntry($type, $value);
            $this->map[$key] = $valueEntry;
        }

        return $this;
    }

    /**
     * @param integer $type
     * @param string $key
     *
     * @return mixed
     *
     * @throws Exception\InvalidPropertyTypeException
     * @throws \OldTown\PropertySet\Exception\PropertyException
     * @throws \OldTown\PropertySet\Exception\DuplicatePropertyKeyException
     */
    protected function get($type, $key)
    {
        if ($this->exists($key)) {
            $v = $this->getMap()[$key];

            if ($type !== $v->getType()) {
                $errMsg = 'Ошибка с типами';
                throw new Exception\DuplicatePropertyKeyException($errMsg);
            }

            $value = $v->getValue();;
            return $value;
        }
        return null;
    }
}
