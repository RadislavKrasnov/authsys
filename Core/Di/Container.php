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
        if ($this->has($id)) {
            return $this->definitions[$id]($this);
        }

        if (!class_exists($id)) {
            throw NotFoundException::create($id);
        }

        $reflector = new \ReflectionClass($id);

        if (!$reflector->isInstantiable()) {
            throw NotFoundException::create($id);
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $id();
        }

        $dependencies = $constructor->getParameters();
        $dependencies = array_map(function (\ReflectionParameter $dependency) use ($id) {

            if (is_null($dependency->getClass())) {
                throw NotFoundException::create($id);
            }

            return $this->get($dependency->getClass()->name);
        }, $dependencies);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @param string $id
     * @param \Closure $value
     */
    public function set($id, \Closure $value)
    {
        $this->definitions[$id] = $value;
    }

    /**
     * @param array $definitions
     */
    public function setDefinitions(array $definitions)
    {
        foreach ($definitions as $id => $value) {
            $this->set($id, $value);
        }
    }

    /**
     * @param string $id
     * @param \Closure $value
     */
    public function share($id, \Closure $value)
    {
        $this->definitions[$id] = function ($container) use ($value) {
            static $object;

            if (is_null($object)) {
                $object = $value($container);
            }

            return $object;
        };
    }

    /**
     * @param array $singletons
     */
    public function setSingletons(array $singletons)
    {
        foreach ($singletons as $id => $value) {
            $this->share($id, $value);
        }
    }

    /**
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
