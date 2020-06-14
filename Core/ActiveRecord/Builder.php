<?php

namespace Core\ActiveRecord;

use Core\ActiveRecord\Model;
use Core\ActiveRecord\Collection;

/**
 * Class Builder
 *
 * @package Core\ActiveRecord
 */
class Builder
{
    /**
     * @var Model
     */
    private $model;

    /**
     * Set model
     *
     * @param Model $model
     * @return Builder
     */
    public function setModel(Model $model): object
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Select query
     *
     * @param string $columns
     * @return Builder
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
     * @return Builder
     */
    public function where(array $conditions): object
    {
        $query = $this->model->getQuery();
        $query->where($conditions);

        return $this;
    }

    /**
     * Or where clause
     *
     * @param array $conditions
     * @param bool $and
     * @return Builder
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

        return $this->model->newInstance($model);
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
     * @return Builder
     */
    public function truncate()
    {
        $query = $this->model->getQuery();
        $query->truncate();

        return $this;
    }
}
