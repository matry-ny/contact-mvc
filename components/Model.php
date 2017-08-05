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

    public function __set($name, $value)
    {
        if (isset($this->{$name})) {
            $this->attributes[$name] = $value;
        } else {
            throw new \Exception("Property '{$name}' in undefined");
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->attributes);
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
     * @param array|int $condition
     * @return $this
     */
    public function find($condition)
    {
        if (is_array($condition)) {
            $query = "SELECT * FROM {$this->table}";
            if ($condition) {
                $query .= ' WHERE';
                foreach (array_keys($condition) as $key) {
                    $query .= " {$key} = ?";
                }
            }

            $stmt = $this->getDbConnect()->prepare($query);
            $stmt->execute(array_values($condition));
        } else {
            $stmt = $this->getDbConnect()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
            $stmt->execute([$condition]);
        }

        $this->load($stmt->fetch(\PDO::FETCH_ASSOC));
        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (empty($this->{$this->primaryKey})) {
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
        }

        $stmt = $this->getDbConnect()->prepare($query);
        return $stmt->execute(array_values($condition));
    }
}