<?php
namespace App\console;

use \App\models\Course;
use \App\models\Valute;
use App\utils\App;

class UpdateCourses
{
    /**
     * Update courses and valutes table

     * @return bool
     */
    public  function updateCourses(): bool
    {
       $model = new Course();

       $currencies = $model->parseXml();
        $fillCourses = [];
        $fillValutes = [];

        if($currencies) {
            $this->buildCoursesItems($currencies,$fillCourses,$fillValutes);
            App::$db->batchInsert(Course::tableName(),$fillCourses,["char_code","vunit_rate"]);
            App::$db->batchInsert(Valute::tableName(),$fillValutes,["char_code","name_valute"],true);
            echo "updated";
            return true;
        }
        echo "Can not parse";
        return  false;
    }

    /**
     * @param \SimpleXMLElement $currencies
     * @param array $fillCourses
     * @param array $fillValutes
     */
    private function buildCoursesItems(
        \SimpleXMLElement $currencies,
        array &$fillCourses,
        array &$fillValutes
    )
    {
        foreach ($currencies as $valute) {
            $courseString = str_replace(
                ',','.',$valute->VunitRate->__toString()
            );

            /*
             * data for insert/update into course table
            */
            $fillCourses[] = [
                $valute->CharCode->__toString(),//уникальное поле
                (double)$courseString
            ];
            /*
             * data for insert/update into valute table
            */
            $fillValutes[] = [
                $valute->CharCode->__toString(),//уникальное поле
                $valute->Name->__toString()
            ];
        }
    }

    /**
     * Clear data in course and valute tables
     */
    public function clearCoursesValutes()
    {
        App::$db->cleanTable(Course::tableName());
        App::$db->cleanTable(Valute::tableName());
    }

}
