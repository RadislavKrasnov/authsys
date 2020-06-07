<?php
namespace Core\Database\QueryBuilder;

use Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface;
use Core\Api\Database\Connection\MySqlConnectionInterface;

/**
 * Class MySqlQueryBuilder
 *
 * @package Core\Database\QueryBuilder
 */
class MySqlQueryBuilder implements MySqlQueryBuilderInterface
{
    /**
     * @var MySqlConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $sql;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $table;

    /**
     * Set database table
     *
     * @param string $table
     * @return MySqlQueryBuilderInterface
     */
    public function table($table): object
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Select query
     *
     * @param string|array $columns
     * @return MySqlQueryBuilderInterface
     */
    public function select($columns = '*'): object
    {
        if (is_array($columns) && !empty($columns)) {
            $columns = implode(', ', $columns);
        }

        $this->sql = "SELECT {$columns} FROM {$this->table}";

        return $this;
    }

    /**
     * Insert query
     *
     * @param array $columns
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function insert($columns, $values): object
    {
        if (!is_array($columns) || empty($columns)) {
            return $this;
        }

        if (!is_array($values) || empty($values)) {
            return $this;
        }

        $columns = implode(', ', $columns);
        $values = implode("', '", $values);
        $this->sql = "INSERT INTO {$this->table}({$columns}) VALUES ('{$values}')";
        $this->executeSqlQuery();

        return $this;
    }

    /**
     * Update query
     *
     * @param array $columns
     * @param array $values
     * @return MySqlQueryBuilderInterface
     */
    public function update($columns, $values): object
    {
        if (!is_array($columns) || empty($columns)) {
            return $this;
        }

        if (!is_array($values) || empty($values)) {
            return $this;
        }

        $updates = [];

        for ($i = 0; $i < count($columns); $i++) {
            $updates[] = "`$columns[$i]` = '$values[$i]'";
        }

        $updates = implode(', ', $updates);
        $this->sql = "UPDATE {$this->table} SET {$updates}" . $this->sql;

        $this->executeSqlQuery();

        return $this;
    }

    /**
     * Delete query
     *
     * @return MySqlQueryBuilderInterface
     */
    public function delete()
    {
        $this->sql = "DELETE FROM {$this->table}" . $this->sql;
        $this->executeSqlQuery();

        return $this;
    }

    /**
     * Truncate query
     *
     * @return MySqlQueryBuilderInterface
     */
    public function truncate(): object
    {
        $this->sql = "TRUNCATE {$this->table}";
        $this->executeSqlQuery();

        return $this;
    }

    /**
     * Set Where clause
     *
     * @param array $conditions
     * @return MySqlQueryBuilderInterface
     */
    public function where($conditions): object
    {
        if (!is_array($conditions) || empty($conditions)) {
            return $this;
        }

        foreach ($conditions as $condition) {
            $field = $condition[0];
            $operator = $condition[1];
            $value = $condition[2];

            if (strpos($this->sql, 'WHERE') === false) {
                $this->sql .= " WHERE `$field`" . ' ' . $operator . ' ' . "'$value'";
                continue;
            }

            $this->sql .= " AND `$field`" . ' ' . $operator . ' ' . "'$value'";
        }

        return $this;
    }

    /**
     * Set Or operator in Where clause
     *
     * @param array $conditions
     * @param bool $and
     * @return MySqlQueryBuilderInterface
     */
    public function orWhere($conditions, $and = false): object
    {
        if (!is_array($conditions) || empty($conditions)) {
            return $this;
        }

        if (!$and) {
            foreach ($conditions as $condition) {
                $field = $condition[0];
                $operator = $condition[1];
                $value = $condition[2];

                $this->sql .= " OR `$field`" . ' ' . $operator . ' ' . "'$value'";
            }

            return $this;
        }

        $this->sql .= " OR (";
        $i = 0;

        foreach ($conditions as $condition) {
            $field = $condition[0];
            $operator = $condition[1];
            $value = $condition[2];

            if ($i === 0) {
                $this->sql .= "`$field`" . ' ' . $operator . ' ' . "'$value'";
                $i++;
                continue;
            }

            $this->sql .= " AND `$field`" . ' ' . $operator . ' ' . "'$value'";
            $i++;
        }

        $this->sql .= ")";

        return $this;
    }

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
    public function join($mainTable, $joinTable, $field, $condition, $joinTableField): object
    {
        $this->sql .= " INNER JOIN $joinTable ON $mainTable.$field $condition $joinTable.$joinTableField";

        return $this;
    }

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
    public function leftJoin($mainTable, $joinTable, $field, $condition, $joinTableField): object
    {
        $this->sql .= " LEFT JOIN $joinTable ON $mainTable.$field $condition $joinTable.$joinTableField";

        return $this;
    }

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
    public function rightJoin($mainTable, $joinTable, $field, $condition, $joinTableField): object
    {
        $this->sql .= " RIGHT JOIN $joinTable ON $mainTable.$field $condition $joinTable.$joinTableField";

        return $this;
    }

    /**
     * Get result of database query
     *
     * @return array
     */
    public function get(): array
    {
        $stmt = $this->executeSqlQuery();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    /**
     * Set Pdo instance
     *
     * @param \PDO
     */
    public function setPdo($pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * Get Pdo instance
     *
     * @return \PDO
     */
    public function getPdo(): object
    {
        return $this->pdo;
    }

    /**
     * Execute SQL query via PDO
     *
     * @return bool|\PDOStatement
     */
    private function executeSqlQuery()
    {
        $this->sql .= ';';
        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        unset($this->sql);
        unset($this->table);

        return $stmt;
    }
}
