<?php

namespace App\models;

use App\utils\App;
use App\utils\Model;
use App\utils\Response;
use PDO;


class CourseHistoryForm extends Model
{
    public string $charCode;
    public string $dateFrom;
    public string $dateTo;

    public function validation():bool
    {
        $timestampFrom = strtotime($this->dateFrom." 00:00:00");
        $timestampTo = strtotime($this->dateTo."23:59:59");
        if(
            !is_numeric($this->charCode)
            &&($timestampFrom && $timestampTo)
            && ($this->dateFrom=date("Y-m-d h:i:s",$timestampFrom)
                && $this->dateTo=date("Y-m-d h:i:s",$timestampTo))
        ) {
            return true;
        }
        return false;
    }

    /**
     * @return Course[]|false|string[]
     */
    public function historyChangeCourse()
    {
        if($this->validation()) {
            $smth = App::$db->pdo->prepare("
            SELECT c.char_code,
                   c.vunit_rate,
                   v.name_valute,
                   c.created_at 
            FROM  " . Course::tableName()
            ." AS c INNER JOIN ".Valute::tableName()." AS v 
            ON c.char_code=v.char_code
                WHERE c.char_code=:char_code AND
                    c.created_at BETWEEN :dateFrom AND :dateTo"
            );
            $smth->bindParam(":char_code", $this->charCode);
            $smth->bindParam(":dateFrom", $this->dateFrom);
            $smth->bindParam(":dateTo", $this->dateTo);
            $smth->execute();
            return $smth->fetchAll(PDO::FETCH_CLASS, Course::class);
        }
        return Response::internalErr("Dates should be in format d-m-Y");
    }
}