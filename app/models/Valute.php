<?php

namespace App\models;

use App\utils\Model;

/**
 * @property string $char_code
 * @property string $name_valute
 */
class Valute extends Model
{
    public static function tableName()
    {
        return "valute";
    }

    public function validation()
    {
        return !is_numeric($this->char_code) && is_string($this->name_valute);
    }

}