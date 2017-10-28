<?php

namespace components;

/**
 * Class Model
 * @package components
 */
abstract class Model
{
    /**
     * @var null|string
     */
    protected $primaryKey = null;

    /**
     * @var null|string
     */
    protected $table = null;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    private $oldAttributes = [];

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __set($name, $value)
    {
        if (isset($this->{$name})) {
            $this->attributes[$name] = $value;
        } else {
            throw new \Exception("Property '{$name}' in undefined");
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->{$name}) ? $this->attributes[$name] : null;
    }

    /**
     * @return \PDO
     */
    public function getDbConnect()
    {
        return Registry::get('db')->getConnection();
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function load(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @param int|array $condition
     * @param string $delimiter
     * @return Model|array
     */
    public function find($condition, $delimiter = 'AND')
    {
        if (is_array($condition)) {
            $query = "SELECT * FROM {$this->table}";
            if ($condition) {
                $query .= ' WHERE ';
                $parts = [];
                foreach (array_keys($condition) as $key) {
                    $parts[] = "{$key} = ?";
                }

                $query .= implode(" {$delimiter} ", $parts);
            }

            $stmt = $this->getDbConnect()->prepare($query);
            $stmt->execute(array_values($condition));
            $result = [];
            foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
                $model = new static();
                $model->load($row);
                $model->oldAttributes = $row;
                $result[] = $model;
            }

            return $result;
        }

        $stmt = $this->getDbConnect()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$condition]);
        $record = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->load($record);
        $this->oldAttributes = $record;

        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $primaryKeyValue = $this->{$this->primaryKey};
        if (empty($primaryKeyValue)) {
            return $this->create();
        } else {
            return $this->update();
        }
    }

    /**
     * @return bool
     */
    protected function create()
    {
        $columns = [];
        $aliases = [];
        $values = [];
        foreach ($this->attributes as $key => $value) {
            if ($key == $this->primaryKey) {
                continue;
            }

            $columns[] = $key;
            if (in_array($key, ['created_at', 'updated_at'])) {
                $aliases[] = 'now()';
            } else {
                $aliases[] = ":{$key}";
                $values[":{$key}"] = $value;
            }
        }

        $columnsString = implode(', ', $columns);
        $aliasesString = implode(', ', $aliases);
        $stmt = $this->getDbConnect()->prepare("INSERT INTO {$this->table} ($columnsString) VALUES ($aliasesString)");

        $isCorrect = $stmt->execute($values);
        if ($isCorrect) {
            $this->find($this->getDbConnect()->lastInsertId());
        }

        return $isCorrect;
    }

    /**
     * @return bool
     */
    protected function update()
    {
        $columns = [];
        $values = [];

        foreach ($this->attributes as $attribute => $value) {
            if ($attribute == 'updated_at') {
                $columns[] = 'updated_at = now()';
            }
            if ($value == $this->oldAttributes[$attribute]) {
                continue;
            }

            $columns[] = "{$attribute} = :{$attribute}";
            $values[":{$attribute}"] = $value;
        }

        $primaryKeyValue = $this->{$this->primaryKey};
        $columnsString = implode(', ', $columns);
        $query = "UPDATE {$this->table} SET {$columnsString} WHERE {$this->primaryKey} = {$primaryKeyValue} LIMIT 1";

        $stmt = $this->getDbConnect()->prepare($query);
        $isCorrect = $stmt->execute($values);

        if ($isCorrect) {
            $this->find($primaryKeyValue);
        }

        return $isCorrect;
    }

    /**
     * @param $queryString
     * @return array
     */
    protected function query($queryString)
    {
        $result = [];
        foreach ($this->getDbConnect()->query($queryString, \PDO::FETCH_ASSOC) as $row) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param string $table
     * @param string $name
     * @param string $type
     * @return \PDOStatement
     */
    public function addColumn($table, $name, $type)
    {
        $query = "ALTER TABLE {$table} ADD {$name} {$type}";
        return $this->getDbConnect()->query($query);
    }

    /**
     * @param string $table
     * @param string $name
     * @return \PDOStatement
     */
    public function dropColumn($table, $name)
    {
        $query = "ALTER TABLE {$table} DROP COLUMN {$name}";
        return $this->getDbConnect()->query($query);
    }

    /**
     * @param string $table
     * @param string $name
     * @param string $column
     * @param string $refTable
     * @param string $refColumn
     * @param string $onDelete
     * @param string $onUpdate
     * @return \PDOStatement
     */
    public function addForeignKey(
        $table,
        $name,
        $column,
        $refTable,
        $refColumn,
        $onDelete = 'CASCADE',
        $onUpdate = 'CASCADE'
    ) {
        $query = <<<SQL
ALTER TABLE {$table} 
  ADD CONSTRAINT {$name} FOREIGN KEY ($column) 
  REFERENCES {$refTable}({$refColumn}) ON DELETE {$onDelete} ON UPDATE {$onUpdate}
SQL;
        return $this->getDbConnect()->query($query);
    }

    /**
     * @param string $table
     * @param string $name
     * @return \PDOStatement
     */
    public function dropForeignKey($table, $name)
    {
        $query = "ALTER TABLE {$table} DROP FOREIGN KEY {$name}";
        return $this->getDbConnect()->query($query);
    }

    /**
     * @return bool
     */
    public function getIsTableExists()
    {
        return (bool)$this->query("SHOW TABLES LIKE '{$this->table}'");
    }

    /**
     * @param string $name
     * @param array $columns
     * @param null $options
     * @return bool
     */
    public function createTable($name, array $columns, $options = null)
    {
        $columnsString = implode(',', $columns);
        return (bool)$this->query("CREATE TABLE {$name} ({$columnsString}) {$options}");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function dropTable($name)
    {
        return (bool)$this->query("DROP TABLE {$name}");
    }

    /**
     * @param array $condition
     * @return bool
     */
    public function delete(array $condition = [])
    {
        $query = "DELETE FROM {$this->table}";
        if ($condition) {
            $query .= ' WHERE';
            foreach (array_keys($condition) as $key) {
                $query .= " {$key} = ?";
            }
        } else {
            $query .= " WHERE {$this->primaryKey} = ? LIMIT 1";
            $condition[$this->primaryKey] = $this->{$this->primaryKey};
        }

        $stmt = $this->getDbConnect()->prepare($query);
        return $stmt->execute(array_values($condition));
    }
}