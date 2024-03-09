<?php

namespace App\utils;

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
        // Is array empty? Nothing to insert!
        if (empty($rows)) {
            return true;
        }

        // Get the column count. Are we inserting all columns or just the specific columns?
        $columnCount = !empty($columns) ? count($columns) : count(reset($rows));

        // Build the column list
        $columnList = !empty($columns) ? '('.implode(', ', $columns).')' : '';

        // Build value placeholders for single row
        $rowPlaceholder = ' ('.implode(', ', array_fill(1, $columnCount, '?')).')';

        // Build the whole prepared query
        if($update) {
            $query = sprintf(
                'INSERT IGNORE INTO %s %s VALUES %s',
                $table,
                $columnList,
                implode(', ', array_fill(1, count($rows), $rowPlaceholder))
            );
        } else {
            $query = sprintf(
                'INSERT INTO %s %s VALUES %s',
                $table,
                $columnList,
                implode(', ', array_fill(1, count($rows), $rowPlaceholder))
            );
        }
        $data = [];
        foreach ($rows as $rowData) {
           $data[] = $rowData;
        }
        // Prepare PDO statement
        $stmt = $this->pdo->prepare($query);

        try {
            $res=$stmt->execute(array_merge(...$data));
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return http_response_code(500);
        }
        return $res;
    }

   /* public function findOne($params=[])
    {
        return
    }*/

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