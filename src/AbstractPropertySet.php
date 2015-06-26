<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;

use DateTime;
use DOMDocument;
use Traversable;

/**
 * Class AbstractPropertySet
 *
 * @package OldTown\PropertySet
 */
abstract class AbstractPropertySet implements PropertySetInterface
{
    /**
     * @var PropertySetSchema
     */
    protected $schema;

    /**
     * @param string $property
     *
     * @return boolean
     */
    public function isSettable($property)
    {
        return true;
    }

    /**
     * @param array $config
     * @param array $args
     *
     * @return $this
     */
    public function init(array $config = [], array  $args = [])
    {
        // TODO: Implement init() method.
    }

    /**
     * @param integer $type
     *
     * @return boolean
     *
     * @throws \OldTown\PropertySet\Exception\PropertyException
     */
    public function supportsType($type)
    {
        return true;
    }

    /**
     *
     */
    public function __toString()
    {
        $result = '';

        $data = '';
        try {
            $keys = $this->getKeys();
            foreach ($keys as $key) {
                $type = $this->getType($key);
                if ($type > 0) {
                    $value = $this->get($type, $key);
                    $data .= sprintf("\t %s = %s \n", $key,  $value);
                }
            }
            $result = sprintf("%s {\n%s}\n", static::class, $data);
        } catch (Exception\PropertyException $e) {

        }

        return $result;
    }


    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setAsActualType($key, $value)
    {
        $type = null;
        if (is_bool($value)) {
            $type = self::BOOLEAN;
        } elseif (is_int($value)) {
            $type = self::INT;
        } elseif (is_float($value)) {
            $type = self::FLOAT;
        } elseif (is_string($value)) {
            $type = strlen($value) > 255 ? self::DATA : self::STRING;
        } elseif ($value instanceof DateTime) {
            $type = self::DATE;
        } elseif ($value instanceof DOMDocument) {
            $type = self::XML;
        } elseif (is_array($value)) {
            $type = self::DATA_ARRAY;
        } elseif (is_object($value)) {
            $type = self::OBJECT;
        } else {
            $errMsg = 'Неизвестный тип';
            throw new Exception\PropertyException($errMsg);
        }

        $this->set($type, $key, $value);
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws Exception\PropertyException
     */
    public function getAsActualType($key)
    {
        $type = $this->getType($key);
        $value = null;
        switch ($type) {
            case self::BOOLEAN: {
                $value = $this->getBoolean($key);
                break;
            }
            case self::INT: {
                $value = $this->getInt($key);
                break;
            }
            case self::FLOAT: {
                $value = $this->getFloat($key);
                break;
            }
            case self::STRING: {
                $value = $this->getString($key);
                break;
            }
            case self::DATE: {
                $value = $this->getDate($key);
                break;
            }
            case self::XML: {
                $value = $this->getXML($key);
                break;
            }
            case self::DATA: {
                $value = $this->getData($key);
                break;
            }
            case self::DATA_ARRAY: {
                $value = $this->getArray($key);
                break;
            }
            case self::OBJECT: {
                $value = $this->getArray($key);
                break;
            }
            default: {
                $errMsg = 'Неизвестный тип';
                throw new Exception\PropertyException($errMsg);
            }
        }

        return $value;
    }

    /**
     * @param string $key
     * @param object $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setObject($key, $value)
    {
        if (!settype($value, 'object')) {
            $errMsg = 'Ошибка при конвертации к типу object';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::OBJECT, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return object
     *
     * @throws Exception\PropertyException
     */
    public function getObject($key)
    {
        try {
            $result = $this->get(self::OBJECT, $key);
            if (!settype($result, 'object')) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param string $key
     * @param array|Traversable $value
     *
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setArray($key, $value)
    {
        $newValue = null;
        if ($value instanceof Traversable) {
            $newValue = [];
            foreach ($value as $k => $v) {
                $newValue[$k] = $v;
            }
        } else {
            $newValue = $value;
        }

        if (!settype($newValue, 'array')) {
            $errMsg = 'Ошибка при конвертации к типу array';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::DATA_ARRAY, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return array
     *
     * @throws Exception\PropertyException
     */
    public function getArray($key)
    {
        try {
            $result = $this->get(self::DATA_ARRAY, $key);
            if (!settype($result, 'array')) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setData($key, $value)
    {
        if (!settype($value, 'string')) {
            $errMsg = 'Ошибка при конвертации к типу data';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::DATA, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws Exception\PropertyException
     */
    public function getData($key)
    {
        try {
            $result = $this->get(self::STRING, $key);
            if (!settype($result, 'string')) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param string      $key
     * @param DOMDocument $value
     *
     * @return $this
     * @throws Exception\PropertyException
     */
    public function setXML($key, DOMDocument $value)
    {
        $this->set(self::XML, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return DOMDocument
     *
     * @throws Exception\PropertyException
     */
    public function getXML($key)
    {
        try {
            $result = $this->get(self::XML, $key);
            if (!$result instanceof DOMDocument) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param String   $key
     * @param DateTime $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setDate($key, DateTime $value)
    {
        $this->set(self::DATE, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return DateTime
     *
     * @throws Exception\PropertyException
     */
    public function getDate($key)
    {
        try {
            $result = $this->get(self::DATE, $key);
            if (!$result instanceof DateTime) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setString($key, $value)
    {
        if (!settype($value, 'string')) {
            $errMsg = 'Ошибка при конвертации к типу string';
            throw new Exception\PropertyException($errMsg);
        }
        if (strlen($value) > 255) {
            $errMsg = 'Строка не должна быть больше 255 символов';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::STRING, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws Exception\PropertyException
     */
    public function getString($key)
    {
        try {
            $result = $this->get(self::STRING, $key);
            if (!settype($result, 'string')) {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
        return $result;
    }


    /**
     * @param string  $key
     * @param boolean $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setBoolean($key, $value)
    {
        if (!settype($value, 'boolean')) {
            $errMsg = 'Ошибка при конвертации к типу bool';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::BOOLEAN, $key, $value);

        return $this;
    }

    /**
     * @param String $key
     *
     * @return boolean
     *
     * @throws Exception\PropertyException
     */
    public function getBoolean($key)
    {
        try {
            $result = $this->get(self::BOOLEAN, $key);
            if (!settype($result, 'boolean')) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
        return $result;
    }

    /**
     * @param string  $key
     * @param integer $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setInt($key, $value)
    {
        if (!settype($value, 'integer')) {
            $errMsg = 'Ошибка при конвертации к типу integer';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::INT, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return integer
     *
     * @throws Exception\PropertyException
     */
    public function getInt($key)
    {
        try {
            $result = $this->get(self::INT, $key);
            if (!settype($result, 'integer')) {
                return 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
        return $result;
    }

    /**
     * @param string $key
     * @param float  $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setFloat($key, $value)
    {
        if (!settype($value, 'float')) {
            $errMsg = 'Ошибка при конвертации к типу float';
            throw new Exception\PropertyException($errMsg);
        }
        $this->set(self::FLOAT, $key, $value);

        return $this;
    }

    /**
     * @param string $key
     *
     * @return float
     */
    public function getFloat($key)
    {
        try {
            $result = $this->get(self::FLOAT, $key);
            if (!settype($result, 'float')) {
                return 0.0;
            }
        } catch (\Exception $e) {
            return 0.0;
        }
        return $result;
    }


    /**
     * @return PropertySetSchema
     */
    public function getSchema()
    {
        return $this->schema;
    }


    /**
     * @param PropertySetSchema $schema
     *
     * @return $this
     */
    public function setSchema(PropertySetSchema $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return boolean
     */
    public function supportsTypes()
    {
        return true;
    }


    /**
     * @param integer $type
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     *
     * @throws Exception\IllegalPropertyException
     * @throws Exception\InvalidPropertyTypeException
     * @throws \OldTown\PropertySet\Exception\PropertyException
     */
    protected function set($type, $key, $value)
    {
        $schema = $this->getSchema();
        if (null !== $schema) {
            $ps = $schema->getPropertySchema($key);

            if (null === $ps && $schema->isRestricted()) {
                $errMsg = sprintf(
                    'Свойство %s явно не указано в схеме',
                    $key
                );
                throw new Exception\IllegalPropertyException($errMsg);
            }

            if ($this->supportsTypes() && ($type !== $ps->getType())) {
                $errMsg = sprintf(
                    'Свойство %s имеет неверный тип %s. Ожидает что тип будет %s',
                    $key,
                    $type,
                    $ps->getType()
                );
                throw new Exception\InvalidPropertyTypeException($errMsg);
            }

            $ps->validate($value);
        }

        $this->setImpl($type, $key, $value);
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

    }


    /**
     * @param integer $type
     * @param string $key
     *
     * @return mixed
     *
     * @throws Exception\InvalidPropertyTypeException
     * @throws \OldTown\PropertySet\Exception\PropertyException
     */
    protected function get(/** @noinspection PhpUnusedParameterInspection */ $type, $key)
    {
        $errMsg = sprintf(
            'Метод %s должен быть релизован в классе потомке',
            __METHOD__
        );
        trigger_error($errMsg, E_USER_ERROR);

    }

    /**
     * @param integer|string $type
     *
     * @return integer|string
     *
     * @throws \OldTown\PropertySet\Exception\RuntimeException
     */
    protected function type($type)
    {
        if (is_numeric($type)) {
            $iniType = (integer)$type;
            $result = $this->getTypeByCode($iniType);
            return $result;
        } elseif (is_string($type)) {
            $result = $this->getTypeByName($type);
            return $result;
        }
        $errMsg = 'Некорректное значение для типа';
        throw new Exception\RuntimeException($errMsg);
    }

    /**
     * @param integer $type
     *
     * @return string
     */
    protected function getTypeByCode($type)
    {
        switch ($type) {
            case self::BOOLEAN:
                return 'boolean';
            case self::INT:
                return 'int';
            case self::FLOAT:
                return 'float';
            case self::STRING:
                return 'string';
            case self::DATE:
                return 'date';
            case self::OBJECT:
                return 'object';
            case self::XML:
                return 'xml';
            case self::DATA:
                return 'data';
            case self::DATA_ARRAY:
                return 'array';

            default:
                return null;
        }
    }

    /**
     * @param string|null $type
     *
     * @return integer
     *
     * @throws \OldTown\PropertySet\Exception\RuntimeException
     */
    protected function getTypeByName($type = null)
    {
        if (null === $type) {
            return 0;
        }

        if (!settype($type, 'string')) {
            $errMsg = 'Оибка при преобразование в тип string';
            throw new Exception\RuntimeException($errMsg);
        }

        $type = strtolower($type);

        if ('boolean' === $type) {
            return self::BOOLEAN;
        }

        if ('int' === $type) {
            return self::INT;
        }

        if ('float' === $type) {
            return  self::FLOAT;
        }
        if ('string' === $type) {
            return  self::STRING;
        }

        if ('date' === $type) {
            return  self::DATE;
        }
        if ('xml' === $type) {
            return self::XML;
        }
        if ('array' === $type) {
            return self::DATA_ARRAY;
        }
        if ('object' === $type) {
            return self::OBJECT;
        }

        return 0;
    }

}

