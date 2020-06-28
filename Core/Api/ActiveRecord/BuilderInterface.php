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
     * Where in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function whereIn(string $field, array $values): object;

    /**
     * Or where in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function orWhereIn(string $field, array $values): object;

    /**
     * Where not in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function whereNotIn(string $field, array $values): object;

    /**
     * Or where not in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function orWhereNotIn(string $field, array $values): object;

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

    /**
     * Get related model
     *
     * @param string $relatedModel
     * @param string $localKey
     * @param string $foreignKey
     * @return boolean|Model
     */
    public function hasOne(string $relatedModel, string $localKey, string $foreignKey);

    /**
     * Get collection of related models
     *
     * @param string $relatedModel
     * @param string $localKey
     * @param string $foreignKey
     * @return Collection|boolean
     */
    public function hasMany(string $relatedModel, string $localKey, string $foreignKey);

    /**
     * Get collection of related models with many to many relationship
     *
     * @param string $relatedModel
     * @param string $pivotTable
     * @param string $localModelKey
     * @param string $relatedModelKey
     * @return Collection|bool
     */
    public function hasManyToMany(
        string $relatedModel,
        string $pivotTable,
        string $localModelKey,
        string $relatedModelKey
    );
}
