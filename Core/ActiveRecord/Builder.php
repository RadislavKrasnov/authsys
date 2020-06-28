<?php

namespace Core\ActiveRecord;

use Core\ActiveRecord\Model;
use Core\ActiveRecord\Collection;
use Core\Api\ActiveRecord\BuilderInterface;
use Core\Api\Di\DiManagerInterface;

/**
 * Class Builder
 *
 * @package Core\ActiveRecord
 */
class Builder implements BuilderInterface
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @var DiManagerInterface
     */
    private $diManager;

    /**
     * Builder constructor.
     *
     * @param DiManagerInterface $diManager
     */
    public function __construct(DiManagerInterface $diManager)
    {
        $this->diManager = $diManager;
    }

    /**
     * Set model
     *
     * @param Model $model
     * @return BuilderInterface
     */
    public function setModel(Model $model): object
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Select query
     *
     * @param string|array $columns
     * @return BuilderInterface
     */
    public function select($columns = '*'): object
    {
        $query = $this->model->getQuery();
        $query->select($columns);

        return $this;
    }

    /**
     * Get result of query
     *
     * @return Collection
     */
    public function get(): object
    {
        $query = $this->model->getQuery();
        $items = $query->get();

        return $this->model->newCollection(array_map(function ($item) {
            return $this->model->newInstance($item, true);
        }, $items));
    }

    /**
     * Where clause
     *
     * @param array $conditions
     * @return BuilderInterface
     */
    public function where(array $conditions): object
    {
        $query = $this->model->getQuery();
        $query->where($conditions);

        return $this;
    }

    /**
     * Where in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function whereIn(string $field, array $values): object
    {
        $query = $this->model->getQuery();
        $query->whereIn($field, $values);

        return $this;
    }

    /**
     * Or where in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function orWhereIn(string $field, array $values): object
    {
        $query = $this->model->getQuery();
        $query->orWhereIn($field, $values);

        return $this;
    }

    /**
     * Where not in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function whereNotIn(string $field, array $values): object
    {
        $query = $this->model->getQuery();
        $query->whereNotIn($field, $values);

        return $this;
    }

    /**
     * Or where not in clause
     *
     * @param string $field
     * @param array $values
     * @return BuilderInterface
     */
    public function orWhereNotIn(string $field, array $values): object
    {
        $query = $this->model->getQuery();
        $query->orWhereNotIn($field, $values);

        return $this;
    }

    /**
     * Or where clause
     *
     * @param array $conditions
     * @param bool $and
     * @return BuilderInterface
     */
    public function orWhere(array $conditions, bool $and = false): object
    {
        $query = $this->model->getQuery();
        $query->orWhere($conditions, $and);

        return $this;
    }

    /**
     * Get first model of query result
     *
     * @return Model|boolean
     */
    public function first()
    {
        $query = $this->model->getQuery();
        $model = $query->first();

        if (!$model) {
            return false;
        }

        return $this->model->newInstance($model, true);
    }

    /**
     * Get model by primary key
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?object
    {
        $query = $this->model->getQuery();
        $primaryKey = $this->model->getPrimaryKey();
        $models = $query->select()->where([[$primaryKey, '=', $id]])->get();

        if(empty($models)) {
            return null;
        }

        return $this->model->newInstance($models[0]);
    }

    /**
     * Truncate table
     *
     * @return BuilderInterface
     */
    public function truncate(): object
    {
        $query = $this->model->getQuery();
        $query->truncate();

        return $this;
    }

    /**
     * Get related model
     *
     * @param string $relatedModel
     * @param string $localKey
     * @param string $foreignKey
     * @return bool|Model
     */
    public function hasOne(string $relatedModel, string $localKey, string $foreignKey)
    {
        $container = $this->diManager->getContainer();
        $relatedModel = $container->get($relatedModel);
        $query = $this->model->getQuery();
        $mainTable = $this->model->getTable();
        $joinTable = $relatedModel->getTable();
        $primaryKey = $this->model->getPrimaryKey();
        $model = $query->select()
            ->join($mainTable, $joinTable, $localKey, '=', $foreignKey)
            ->where([[$mainTable . '.' . $primaryKey, '=', $this->model->{$primaryKey}]])
            ->first();

        if (!$model) {
            return false;
        }

        return $relatedModel->newInstance($model, true);
    }

    /**
     * Get collection of related models
     *
     * @param string $relatedModel
     * @param string $localKey
     * @param string $foreignKey
     * @return Collection|boolean
     */
    public function hasMany(string $relatedModel, string $localKey, string $foreignKey)
    {
        $container  = $this->diManager->getContainer();
        $relatedModel = $container->get($relatedModel);
        $mainTable = $this->model->getTable();
        $primaryKey = $this->model->getPrimaryKey();
        $joinTable = $relatedModel->getTable();
        $query = $this->model->getQuery();

        $models = $query->select()
            ->join($mainTable, $joinTable, $localKey, '=', $foreignKey)
            ->where([[$mainTable . '.' . $primaryKey, '=', $this->model->{$primaryKey}]])
            ->get();

        if (empty($models)) {
            return false;
        }

        return $relatedModel->newCollection(array_map(function ($model) use ($relatedModel) {
            return $relatedModel->newInstance($model, true);
        }, $models));
    }
}
