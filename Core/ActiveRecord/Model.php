<?php

namespace Core\ActiveRecord;

use Core\Database\Connection;
use Core\Database\ConnectionResolver;
use Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface;
use Core\Api\Database\Connection\MySqlConnectionInterface;
use Core\ActiveRecord\Collection;

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
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
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
     * @return void
     */
    protected function fill(array $attributes): void
    {
        foreach ($this->getFillableAttributes($attributes) as $key => $value) {

            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
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
    protected function getQuery()
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
        $query->insert($fields, $values);

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
            return $this->newInstance($item);
        }, $items));
    }

    /**
     * Get new instance of an entity
     *
     * @param array $attributes
     * @return Model
     */
    public function newInstance(array $attributes = []): object
    {
        return new static($attributes);
    }

    /**
     * Get new collection of the entities
     *
     * @param array $models
     * @return Connection
     */
    public function newCollection(array $models = []): object
    {
        return new Collection($models);
    }

    /**
     * Select model attributes to get
     *
     * @param string|array $columns
     * @return Model
     */
    public function select($columns = '*'): object
    {
        $query = $this->getQuery();
        $query->select($columns);

        return $this;
    }

    /**
     * Get result of query
     *
     * @return Connection
     */
    public function get(): object
    {
        $query = $this->getQuery();
        $items = $query->get();

        return $this->newCollection(array_map(function ($item) {
            return $this->newInstance($item);
        }, $items));
    }

    /**
     * Where clause
     *
     * @param array $conditions
     * @return Model
     */
    public function where(array $conditions)
    {
        $query = $this->getQuery();
        $query->where($conditions);

        return $this;
    }
}