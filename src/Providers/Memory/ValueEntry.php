<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Providers\Memory;

/**
 * Class ValueEntry
 *
 * @package OldTown\PropertySet\Providers\Memory
 */
class ValueEntry
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @param mixed $value
     * @param integer|null $type
     */
    public function __construct($value = null, $type = null)
    {
        if (null !== $value) {
            $this->setValue($value);
        }

        if (null !== $type) {
            $this->setType($type);
        }

    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = (integer)$type;

        return $this;
    }



}
