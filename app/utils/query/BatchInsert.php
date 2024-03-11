<?php
namespace App\utils\query;

use App\utils\App;
use App\utils\Db;

class BatchInsert extends \App\utils\Model
{
    public string $table;
    public array $rows;
    public array $columns;
    public bool $update=false;
    private string $columnList;
    private string $rowPlaceholder;

    public function __construct(Db $db)
    {
        parent::__construct();
        $this->db = $db;
    }

    public function validation()
    {
        // TODO: Implement validation() method.
    }

    public function insert(): bool|int
    {
        // Is array empty? Nothing to insert!
        if (empty($this->rows)) {
            return true;
        }
        // Build the whole prepared query
        $format = ($this->update)?'INSERT IGNORE INTO %s %s VALUES %s':
            'INSERT INTO %s %s VALUES %s';
        $this->buildParam();
        $query = $this->buildQuery($format);

        $data = $this->fillData($this->rows);
        // Prepare PDO statement
        $stmt = $this->db->pdo->prepare($query);

        try {
            $res=$stmt->execute(array_merge(...$data));
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return http_response_code(500);
        }
        return $res;
    }

    private function fillData(array $rows): array
    {
        $data = [];
        foreach ($rows as $rowData) {
            $data[] = $rowData;
        }
        return $data;
    }

    private function buildParam()
    {
        // Get the column count. Are we inserting all columns or just the specific columns?
        $columnCount = !empty($this->columns) ? count($this->columns) : count(reset($this->rows));

        // Build the column list
        $this->columnList = !empty($this->columns) ? '('.implode(', ', $this->columns).')' : '';

        // Build value placeholders for single row
        $this->rowPlaceholder = ' ('.implode(', ', array_fill(1, $columnCount, '?')).')';

    }

    private function buildQuery(string $format)
    {
        return sprintf(
            $format,
            $this->table,
            $this->columnList,
            implode(', ', array_fill(1, count($this->rows), $this->rowPlaceholder))
        );
    }

}