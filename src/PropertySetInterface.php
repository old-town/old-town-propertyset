<?php
/**
 * @link    https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;

use DateTime;
use DOMDocument;
use Traversable;


/**
 * Interface PropertySetInterface
 *
 * @package OldTown\PropertySet
 */
interface PropertySetInterface
{
    /**
     *
     * Булевый тип
     *
     * @var integer
     */
    const BOOLEAN = 1;

    /**
     * Строка  с большими дланныи
     *
     * @var integer
     */
    const DATA = 10;

    /**
     * Дата - объект инкапсулированный от \DateTime
     *
     * @var integer
     */
    const DATE = 7;

    /**
     * Целочисловое значение
     *
     * @var integer
     */
    const INT = 2;

    /**
     * Целочисловое значение
     *
     * @var integer
     */
    const FLOAT = 4;

    /**
     * Объект
     *
     * @var integer
     */
    const OBJECT = 8;

    /**
     * Массив
     *
     * @var integer
     */
    const DATA_ARRAY = 11;

    /**
     * Строка
     *
     * @var integer
     */
    const STRING = 5;

    /**
     * Объект типа DOMDocument
     *
     * @var integer
     */
    const XML = 9;

    //~ Methods ////////////////////////////////////////////////////////////////

    /**
     * @param PropertySetSchema $schema
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setSchema(PropertySetSchema $schema);

    /**
     * @return PropertySetSchema
     *
     * @throws Exception\PropertyException
     */
    public function getSchema();

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setAsActualType($key, $value);

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws Exception\PropertyException
     */
    public function getAsActualType($key);

    /**
     * @param string  $key
     * @param boolean $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setBoolean($key, $value);

    /**
     * @param String $key
     *
     * @return boolean
     *
     * @throws Exception\PropertyException
     */
    public function getBoolean($key);

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setData($key, $value);

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws Exception\PropertyException
     */
    public function getData($key);

    /**
     * @param String   $key
     * @param DateTime $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setDate($key, DateTime $value);

    /**
     * @param string $key
     *
     * @return DateTime
     *
     * @throws Exception\PropertyException
     */
    public function getDate($key);

    /**
     * @param string $key
     * @param float  $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setFloat($key, $value);

    /**
     * @param string $key
     *
     * @return float
     */
    public function getFloat($key);

    /**
     * @param string  $key
     * @param integer $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setInt($key, $value);

    /**
     * @param string $key
     *
     * @return integer
     *
     * @throws Exception\PropertyException
     */
    public function getInt($key);

    /**
     * @return array
     *
     * @throws Exception\PropertyException
     */

    /**
     * @param string|null  $prefix
     * @param integer|null $type
     *
     * @return array
     *
     * @throws Exception\PropertyException
     */
    public function getKeys($prefix = null, $type = null);


    /**
     * @param string $key
     * @param object $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setObject($key, $value);

    /**
     * @param string $key
     *
     * @return object
     *
     * @throws Exception\PropertyException
     */
    public function getObject($key);

    /**
     * @param string $key
     * @param array|Traversable $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setArray($key, $value);

    /**
     * @param string $key
     *
     * @return array
     *
     * @throws Exception\PropertyException
     */
    public function getArray($key);

    /**
     * @param string $property
     *
     * @return boolean
     */
    public function isSettable($property);

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function setString($key, $value);

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws Exception\PropertyException
     */
    public function getString($key);

    /**
     * @param string $key
     *
     * @return integer
     *
     * @throws Exception\PropertyException
     */
    public function getType($key);

    /**
     * @param string      $key
     * @param DOMDocument $value
     *
     * @return $this
     * @throws Exception\PropertyException
     */
    public function setXML($key, DOMDocument $value);

    /**
     * @param string $key
     *
     * @return DOMDocument
     *
     * @throws Exception\PropertyException
     */
    public function getXML($key);

    /**
     * @param string $key
     *
     * @return boolean
     *
     * @throws Exception\PropertyException
     */
    public function exists($key);

    /**
     * @param array $config
     * @param array $args
     *
     * @return $this
     */
    public function init(array $config = [], array  $args = []);


    /**
     * @param string $key
     *
     * @return $this
     *
     * @throws Exception\PropertyException
     */
    public function remove($key);

    /**
     * @param integer $type
     *
     * @return boolean
     */
    public function supportsType($type);

    /**
     * @return boolean
     */
    public function supportsTypes();
}
