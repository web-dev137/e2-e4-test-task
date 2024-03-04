<?php

namespace App\handlers;

use App\models\Course;
use App\models\CourseHistoryForm;
use App\utils\App;
use App\utils\Response;
use PDO;

class ConverterApi
{

    public function hello()
    {
        //$m = new Course();
        //$c = $m->parseXml();
       // echo  $a."+".$b."=";

        return ["data"=>"n"];
    }

    public function convert(string $from, string $to, float|int $val)
    {
        $model = new Course();

        if($from != $to) {

            $model->setFromTo($from,$to, $val);

            if($from && $to) {
                $res = $val * $from/$to; //formula for convert valutes
                return round($res,2);
            }
            return Response::internalErr();
        }
        return Response::internalErr("can not parse");
    }

    /**
     * @return Course[]|string[]|false
     */
    public function getHistoryChangeCourse()
    {
        $model = new CourseHistoryForm();
        $model->load(App::getPostParams());
        return $model->historyChangeCourse();
    }
}