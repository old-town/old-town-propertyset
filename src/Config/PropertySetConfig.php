<?php
/**
 * @link https://github.com/old-town/old-town-propertyset
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace OldTown\PropertySet\Config;
use OldTown\PropertySet\Exception\InvalidArgumentException;

/**
 * Class PropertySetConfig
 *
 * @package OldTown\PropertySet\Config
 */
class PropertySetConfig
{
    /**
     * @var PropertySetConfig
     */
    protected static $instance;

    /**
     * @var array
     */
    protected $propertySetArgs;

    /**
     * @var array
     */
    protected $propertySets;

    /**
     *
     * @throws \OldTown\PropertySet\Exception\InvalidArgumentException
     */
    protected function __construct()
    {
        $this->init();
    }

    /**
     *
     * @return PropertySetConfig
     */
    public static function getConfig()
    {
        return self::getInstance();
    }

    /**
     *
     * @return PropertySetConfig
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *
     * @return $this
     *
     * @throws \OldTown\PropertySet\Exception\InvalidArgumentException
     */
    protected function init()
    {
        $defaultConfig = include __DIR__ . '/../../config/propertyset.default.config.php';
        $userConfig = $this->getUserConfig();

        $config = array_merge_recursive($defaultConfig, $userConfig);

        foreach ($config as $name => $data) {
            if (!is_array($data)) {
                $errMsg = sprintf(
                    'Некорректный формат данных для сервиса %s',
                    $name
                );
                throw new InvalidArgumentException($errMsg);
            }


            if (!array_key_exists('class', $data)) {
                $errMsg = sprintf(
                    'Отсутствует имя класса для сервиса %s',
                    $name
                );
                throw new InvalidArgumentException($errMsg);
            }



            $this->propertySets[$name] = (string)$data['class'];


            $flagHasArgs = array_key_exists('args',$data) && is_array($data['args']);
            $this->propertySetArgs[$name] = $flagHasArgs  ? $data['args'] : [];

        }



        return $this;
    }

    /**
     * @todo Реализовать возможность добавления пользователем конфигов
     *
     * @return array
     */
    protected function getUserConfig()
    {
        return [];
    }

    /**
     * @param $name
     *
     * @return array|null
     */
    public function getArgs($name)
    {
        $name = (string)$name;
        if (array_key_exists($name, $this->propertySetArgs)) {
            return $this->propertySetArgs[$name];
        }
        return null;
    }

    /**
     * @param $name
     *
     * @return string|null
     */
    public function getClassName($name)
    {
        $name = (string)$name;
        if (array_key_exists($name, $this->propertySets)) {
            return $this->propertySets[$name];
        }

        return null;
    }
}
