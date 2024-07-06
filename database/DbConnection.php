<?php

class DbConnection
{
    private $charset = 'utf8mb4';
    private $pdo;
    private $error;
    private $stmt;
    private static $instance = null;

    public function __construct(
        protected string $host,
        protected string $username,
        protected string $password,
        protected string $port,
        protected string $dbName,
    ) {

        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbName};charset={$this->charset}";

        $options = [
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];

        try {
            $this->pdo = new \PDO($dsn, $this->username, $this->password, $options);
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql)
    {
        $this->stmt = $this->pdo->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get a single record as an object
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    // Get the last inserted ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    // Transactions
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->pdo->commit();
    }

    public function cancelTransaction()
    {
        return $this->pdo->rollBack();
    }

    // Debugging
    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function insertMany($table, $data)
    {
        $keys = array_keys($data[0]);
        $fields = implode(',', $keys);
        $placeholders = implode(',', array_fill(0, count($keys), '?'));

        $this->beginTransaction();
        foreach ($data as $row) {
            $values = array_values($row);
            $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
            $this->query($sql);
            foreach ($values as $index => $value) {
                $this->bind($index + 1, $value);
            }
            $this->execute();
        }
        $this->endTransaction();
    }
}
