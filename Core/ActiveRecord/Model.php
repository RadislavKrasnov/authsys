<?php

namespace Core\ActiveRecord;

use Core\Database\ConnectionResolver;
use Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface;
use Core\Api\Database\Connection\MySqlConnectionInterface;
use Core\ActiveRecord\Collection;
use Core\ActiveRecord\Builder;
use Core\Api\Di\DiManagerInterface;

/**
 * Class Model
 *
 * @package Core\ActiveRecord
 */
class Model
{
    /**
     * Model's table
     *
     * @var string
     */
    protected $table;

    /**
     * Model's table primary key
     *
     * @var string
     */
    protected $primaryKey;

    /**
     * Model's attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Model's fillable attributes
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Database connection resource name
     *
     * @var string
     */
    protected $connectionName = 'default';

    /**
     * If model exists in database or not
     *
     * @var bool
     */
    protected $exists = false;

    /**
     * Dependency Injection manager
     *
     * @var DiManagerInterface
     */
    protected $diManager;

    /**
     * Model constructor.
     *
     * @param DiManagerInterface $diManager
     */
    public function __construct(
        DiManagerInterface $diManager
    ) {
        $this->diManager = $diManager;
    }

    /**
     * Set attribute of model
     *
     * @param string $key
     * @param mixed $value
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Check if attribute can be set
     *
     * @param string $key
     * @return bool
     */
    protected function isFillable(string $key): bool
    {
        if (in_array($key, $this->fillable)) {
            return true;
        }

        return false;
    }

    /**
     * Get all attributes that can be set
     *
     * @param array $attributes
     * @return array
     */
    protected function getFillableAttributes(array $attributes): array
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * Set attributes in model
     *
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes): object
    {
        foreach ($this->getFillableAttributes($attributes) as $key => $value) {

            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * Conver camel case attribute to snake case
     *
     * @param string $key
     * @return string
     */
    private function toSnakeCase(string $key): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
    }

    /**
     * Set model attribute
     *
     * @param string $key
     * @param mixed $value
     * @return Model
     * @throws \Exception
     */
    public function __set($key, $value): object
    {
        $key = $this->toSnakeCase($key);

        if (!$this->isFillable($key)) {
            throw new \Exception("{$key} is not valid property");
        }

        $this->setAttribute($key, $value);

        return $this;
    }

    /**
     * Get model attribute
     *
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $key)
    {
        $key = $this->toSnakeCase($key);

        if (!isset($this->attributes[$key])) {
            throw new \Exception("{$key} is not valid property");
        }

        return $this->attributes[$key];
    }


    /**
     * Get connection to the database
     *
     * @return MySqlConnectionInterface
     */
    protected function getConnection(): object
    {
        return ConnectionResolver::getConnection($this->connectionName);
    }

    /**
     * Get query builder
     *
     * @return MySqlQueryBuilderInterface
     */
    public function getQuery()
    {
        return $this->getConnection()->query()->table($this->table);
    }

    /**
     * Save the model data to the database
     *
     * @return Model
     */
    public function save(): object
    {
        $fields = array_keys($this->attributes);
        $values = array_values($this->attributes);
        $query = $this->getQuery();

        if ($this->exists) {
            $query->where([[$this->primaryKey, '=', $this->id]])
                  ->update($fields, $values);
        } else {
            $query->insert($fields, $values);
        }

        return $this;
    }

    /**
     * Get all models of an entity
     *
     * @return Collection
     */
    public function getAll(): object
    {
        $query = $this->getQuery();
        $items = $query->select()->get();

        return $this->newCollection(array_map(function ($item) {
            return $this->newInstance($item, true);
        }, $items));
    }

    /**
     * Delete model
     *
     * @return Model
     */
    public function delete()
    {
        $query = $this->getQuery();
        $query->where([[$this->primaryKey, '=', $this->id]])->delete();

        return $this;
    }

    /**
     * Get new instance of an entity
     *
     * @param array $attributes
     * @param bool $exists
     * @return Model
     */
    public function newInstance(array $attributes = [], bool $exists = false): object
    {
        $container = $this->diManager->getContainer();
        $interfaces = class_implements($this);
        $model = null;

        if (!empty($interfaces)) {
            $interface = reset($interfaces);
            $model = $container->get($interface);
        } else {
            $model = $container->get(get_class($this));
        }

        $model->fill($attributes);
        $model->exists = $exists;

        return $model;
    }

    /**
     * Get new collection of the entities
     *
     * @param array $models
     * @return Collection
     */
    public function newCollection(array $models = []): object
    {
        return new Collection($models);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $builder = new Builder;
        $builder->setModel($this);

        return call_user_func_array([$builder, $name], $arguments);
    }

    /**
     * Get primary key
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Get connection name
     *
     * @return string
     */
    public function getConnectionName(): string
    {
        return $this->connectionName;
    }
}
