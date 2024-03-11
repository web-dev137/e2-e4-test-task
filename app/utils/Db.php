<?php

namespace App\utils;

use App\utils\query\BatchInsert;

final class Db
{
    public \PDO $pdo;

    public function __construct(array $configDB)
    {
        $this->pdo = $this->connect($configDB);
    }

    /**
     * @param array $config
     * @return \PDO
     */
    protected function connect(array $config): \PDO
    {
        $dns = sprintf(
            "mysql:host=%s;port=%s;dbname=%s;",
             $config['host'],
             $config['port'],
             $config['dbname']
        );

        try{
            $pdo = new \PDO($dns,$config['user'], $config['password']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            die($e->getMessage());
        }

        return $pdo;
    }

    /**
     * @param string $table
     * @param array $rows
     * @param array $columns
     * @return bool
     */
    public function batchInsert(string $table,array $rows,array $columns,bool $update=false): bool
    {
        $queryModel = new BatchInsert($this);
        $queryModel->load([
            "table"=> $table,
            "rows" => $rows,
            "columns" => $columns,
            "update" => $update
        ]);
        return $queryModel->insert();
    }

    /**
     * @param string $tableName
     * @return bool|int
     */
    public function cleanTable(string $tableName): bool|int
    {

        $query = sprintf(
            'DELETE FROM %s',
            $tableName
        );

        $stmt = $this->pdo->prepare($query);
        try {
            $res=$stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return http_response_code(500);
        }
        return $res;
    }
}