<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;

use OldTown\PropertySet\Exception\IllegalPropertyException;
use OldTown\PropertySet\Verifiers\Exception\VerifyException;
use OldTown\PropertySet\Verifiers\PropertyVerifierInterface;
use SplObjectStorage;


/**
 * Class PropertySchema
 *
 * @package OldTown\PropertySet
 */
class PropertySchema
{
    /**
     * @var SplObjectStorage|PropertyVerifierInterface[]
     */
    protected $verifiers;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var integer
     */
    protected $type;

    /**
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->verifiers = new SplObjectStorage();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string)$name;

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

    /**
     * @return SplObjectStorage|PropertyVerifierInterface[]
     */
    public function getVerifiers()
    {
        return $this->verifiers;
    }

    /**
     * @param PropertyVerifierInterface $pv
     *
     * @return $this
     */
    public function addVerifier(PropertyVerifierInterface $pv)
    {
        $this->verifiers->attach($pv);

        return $this;
    }


    /**
     * @param PropertyVerifierInterface $pv
     *
     * @return $this
     */
    public function removeVerifier(PropertyVerifierInterface $pv)
    {
        $this->verifiers->detach($pv);

        return $this;
    }

    /**
     * @param $value
     *
     * @return void
     *
     * @throws IllegalPropertyException
     */
    public function validate($value)
    {
        $verifiers = $this->getVerifiers();
        foreach ($verifiers as $pv) {
            try {
                $pv->verify($value);
            } catch (VerifyException $e) {
                throw new IllegalPropertyException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
