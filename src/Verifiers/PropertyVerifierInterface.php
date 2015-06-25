<?php
/**
 * @link    https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Verifiers;
use OldTown\PropertySet\Verifiers\Exception\VerifyException;

/**
 * Interface PropertySetInterface
 *
 * @package OldTown\PropertySet\Verifiers
 */
interface PropertyVerifierInterface
{
    /**
     * @param mixed $value
     *
     * @return void
     *
     * @throws VerifyException
     */
    public function verify($value);
}
