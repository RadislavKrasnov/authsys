<?php

namespace Core\Api\Database\QueryBuilder;

/**
 * Interface MySqlQueryBuilderInterface
 *
 * @package Core\Api\Database\QueryBuilder
 */
interface MySqlQueryBuilderInterface
{
    /**
     * Set database table
     *
     * @param string $table
     * @return MySqlQueryBuilderInterface
     */
    public function table($table): object;

    /**
     * Select query
     *
     * @param string|array $columns
     * @return MySqlQueryBuilderInterface
     */
    public function select($columns = '*'): object;

    /**
     * Insert query
     *
     * @param array $columns
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function insert($columns, $values): object;

    /**
     * Update query
     *
     * @param array $columns
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function update($columns, $values): object;

    /**
     * Delete query
     *
     * @return MySqlQueryBuilderInterface
     */
    public function delete();

    /**
     * Truncate query
     *
     * @return MySqlQueryBuilderInterface
     */
    public function truncate(): object;

    /**
     * Set Where clause
     *
     * @param array $conditions
     * @return MySqlQueryBuilderInterface
     */
    public function where($conditions): object;

    /**
     * Set Or operator in Where clause
     *
     * @param array $conditions
     * @param bool $and
     * @return MySqlQueryBuilderInterface
     */
    public function orWhere($conditions, $and = false): object;

    /**
     * Where In clause
     *
     * @param string $field
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function whereIn(string $field, array $values): object;

    /**
     * Or where in clause
     *
     * @param string $field
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function orWhereIn(string $field, array $values): object;

    /**
     * Where not in clause
     *
     * @param string $field
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function whereNotIn(string $field, array $values): object;

    /**
     * Or where not in clause
     *
     * @param string $field
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function orWhereNotIn(string $field, array $values): object;

    /**
     * Get first row of result
     *
     * @return array|boolean
     */
    public function first();

    /**
     * Inner join clause
     *
     * @param string $mainTable
     * @param string $joinTable
     * @param string $field
     * @param string $condition
     * @param string $joinTableField
     * @return MySqlQueryBuilderInterface
     */
    public function join($mainTable, $joinTable, $field, $condition, $joinTableField): object;

    /**
     * Left join clause
     *
     * @param string $mainTable
     * @param string $joinTable
     * @param string $field
     * @param string $condition
     * @param string $joinTableField
     * @return MySqlQueryBuilderInterface
     */
    public function leftJoin($mainTable, $joinTable, $field, $condition, $joinTableField): object;

    /**
     * Right join clause
     *
     * @param string $mainTable
     * @param string $joinTable
     * @param string $field
     * @param string $condition
     * @param string $joinTableField
     * @return MySqlQueryBuilderInterface
     */
    public function rightJoin($mainTable, $joinTable, $field, $condition, $joinTableField): object;

    /**
     * Get result of database query
     *
     * @return array
     */
    public function get(): array;

    /**
     * Set Pdo instance
     *
     * @param \PDO
     */
    public function setPdo($pdo): void;

    /**
     * Get Pdo instance
     *
     * @return \PDO
     */
    public function getPdo(): object;
}
