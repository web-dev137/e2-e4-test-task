<?php

namespace App\models;

use App\utils\Model;

use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="Valute",
 *   required={"char_code","name_valute"}
 * ),
 * @OA\Property(
 *     property="char_code",
 *     type="string",
 *     description="Char code of valute (USD,EUR,RUB...)",
 *     example="EUR"
 * ),
 * @OA\Property(
 *     property="name_valute",
 *     type="string",
 *     description="Char code of valute (USD,EUR,RUB...)",
 *     example="EUR"
 * ),
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