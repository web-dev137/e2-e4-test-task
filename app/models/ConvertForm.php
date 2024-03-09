<?php

namespace App\models;

use App\utils\Model;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="ConvertForm",
 *   required={"fromCharCode","toCharCode","val"}
 *  ),
*/
class ConvertForm extends Model
{
    /**
     *  @OA\Property(
     *     property="fromCharCode",
     *     type="string",
     *     description="Char code of valute (USD,EUR,RUB...)",
     *     example="EUR"
     *  ),
     */
    public string $fromCharCode;
    /**
     *  @OA\Property(
     *     property="toCharCode",
     *     type="string",
     *     description="Char code of valute (USD,EUR,RUB...)",
     *     example="USD"
     *  ),
     */
    public string $toCharCode;
    /**
     *  @OA\Property(
     *     property="val",
     *     type="integer",
     *     description="Amount for convertation",
     *     example="3"
     *  ),
     */
    public int|float $val;
    private float $fromCourse;
    private float $toCourse;

    public function validation(): bool
    {
        if ($this->fromCharCode
            && $this->toCharCode
            && is_numeric($this->val)){
            return true;
        }
        return false;
    }
    public function setFrom(float $from)
    {
        $this->fromCourse = $from;
    }
    public function setTo(float $to)
    {
        $this->toCourse = $to;
    }
    public function getFrom(): float
    {
        return $this->fromCourse;
    }
    public function getTo(): float
    {
        return $this->toCourse;
    }
}