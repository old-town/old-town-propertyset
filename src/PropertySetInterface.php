<?php
/**
 * @link    https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet;

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
     * @var \DateTime
     */
    const DATE = 7;

    /**
     * Целочисловое значение
     *
     * @var integer
     */
    const INT = 2;

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
}
