<?php

namespace App\models;

use App\utils\App;
use App\utils\Model;
use App\utils\Response;
use PDO;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="CourseHistoryForm",
 *   required={"charCode","dateFrom","dateTo"}
 *  ),
 */
class CourseHistoryForm extends Model
{
    /**
     *  @OA\Property(
     *     property="charCode",
     *     type="string",
     *     description="Char code of valute (USD,EUR,RUB...)",
     *     example="EUR"
     *  ),
     */
    public string $charCode;
    /**
     *  @OA\Property(
     *     property="dateFrom",
     *     type="string",
     *     description="Start date",
     *     example="05-03-2024"
     *  ),
     */
    public string $dateFrom;
    /**
     *  @OA\Property(
     *     property="dateTo",
     *     type="string",
     *     description="End date",
     *     example="07-03-2024"
     *  ),
     */
    public string $dateTo;

    public function validation():bool
    {
        $timestampFrom = strtotime($this->dateFrom."00:00:00");
        $timestampTo = strtotime($this->dateTo."23:59:59");
        $this->dateFrom=date("Y-m-d H:i:s",$timestampFrom);
        $this->dateTo=date("Y-m-d H:i:s",$timestampTo);
        return !is_numeric($this->charCode)
        &&($timestampFrom && $timestampTo)
        && ($this->dateFrom
            && $this->dateTo);
    }

    /**
     * @return array[]|bool|string[]
     */
    public function historyChangeCourse()
    {
        if($this->validation()) {
            $query = "
                SELECT c.char_code,
                       c.vunit_rate,
                       v.name_valute,
                       CONVERT_TZ(c.created_at,'+03:00','Asia/Novosibirsk') AS created_at
                FROM  " . Course::tableName() ." AS c 
                INNER JOIN ".Valute::tableName()." AS v 
                ON c.char_code=v.char_code
                WHERE c.char_code=? AND
                        c.created_at BETWEEN ? AND ?";
            $smth = App::$db->pdo->prepare($query);
            $smth->execute([$this->charCode,$this->dateFrom,$this->dateTo]);
            return $smth->fetchAll(PDO::FETCH_ASSOC);
        }
        return Response::internalErr("Dates should be in format d-m-Y");
    }
}