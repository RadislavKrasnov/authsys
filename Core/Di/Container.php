<?php

namespace Core\Di;

use Core\Api\Di\ContainerInterface;
use Core\Di\NotFoundException;

/**
 * Class Container
 * @package Core\Di
 */
class Container implements ContainerInterface, \ArrayAccess
{
    /**
     * Definitions
     *
     * @var array
     */
    private $definitions = [];

    /**
     * Check if definition exists
     *
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->definitions);
    }

    /**
     * Get definition
     *
     * @param string $id
     * @return object
     * @throws \Core\Di\NotFoundException
     * @throws \ReflectionException
     */
    public function get($id)
    {
        $class = null;

        if ($this->has($id)) {
            $class = $this->definitions[$id];
        } else {
            throw NotFoundException::create($id);
        }

        if (!class_exists($class)) {
            throw NotFoundException::create($id);
        }

        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw NotFoundException::create($id);
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class();
        }

        $dependencies = $constructor->getParameters();
        $dependencies = array_map(function (\ReflectionParameter $dependency) use ($class) {

            if (is_null($dependency->getClass())) {
                throw NotFoundException::create($class);
            }

            return $this->get($dependency->getClass()->name);
        }, $dependencies);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Set definition
     *
     * @param string $id
     * @param string $value
     */
    public function set($id, $value)
    {
        $this->definitions[$id] = $value;
    }

    /**
     * Get singletone
     *
     * @param string $id
     * @return object
     */
    public function share($id)
    {
        static $object;

        if (is_null($object)) {
            $object = $this->get($id);
        }

        return $object;
    }

    /**
     * Remove definition
     *
     * @param string $id
     */
    public function remove($id)
    {
        if ($this->has($id)) {
            unset($this->definitions[$id]);
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|object
     * @throws \Core\Di\NotFoundException
     * @throws \ReflectionException
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}
