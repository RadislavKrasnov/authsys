<?php

namespace Core\Api\ActiveRecord;

use Core\ActiveRecord\Model;
use Core\ActiveRecord\Collection;

interface BuilderInterface
{
    /**
     * Set model
     *
     * @param Model $model
     * @return BuilderInterface
     */
    public function setModel(Model $model): object;

    /**
     * Select query
     *
     * @param string|array $columns
     * @return BuilderInterface
     */
    public function select(string $columns = '*'): object;

    /**
     * Get result of query
     *
     * @return Collection
     */
    public function get(): object;

    /**
     * Where clause
     *
     * @param array $conditions
     * @return BuilderInterface
     */
    public function where(array $conditions): object;

    /**
     * Or where clause
     *
     * @param array $conditions
     * @param bool $and
     * @return BuilderInterface
     */
    public function orWhere(array $conditions, bool $and = false): object;

    /**
     * Get first model of query result
     *
     * @return Model|boolean
     */
    public function first();

    /**
     * Get model by primary key
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?object;

    /**
     * Truncate table
     *
     * @return BuilderInterface
     */
    public function truncate(): object;
}
