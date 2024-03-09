<?php

namespace App\utils;

abstract class Model
{
    protected Db $db;
    public function __construct()
    {
        $this->db = App::$db;
    }
    public function load(array $data): bool
    {
        if(!empty($data)) {
            $obj = (object)$data;
            foreach ($obj as $key => $val) {
                if (property_exists($this, $key)) {
                    $this->$key = $val;
                }
            }
            return true;
        }
        return false;
    }

    public function __get($key)
    {
        return $this->$key;
    }

    abstract public function validation();
}