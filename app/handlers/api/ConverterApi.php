<?php

namespace App\handlers\api;

use App\models\ConvertForm;
use App\models\Course;
use App\models\CourseHistoryForm;
use App\utils\App;
use App\utils\Response;
use PDO;
use OpenApi\Annotations as QA;

/**
 * @QA\Info(
 *      title="Convert API",
 *      version="1.0"
 * ),
 *  @OA\Post(
 *     tags={"Unathorize"},
 *     path="/api/convert",
 *     description="Convert valute",
 *     @QA\RequestBody(
 *          required=true,
 *          @QA\JsonContent(ref="#/components/schemas/ConvertForm")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Result",
 *         @QA\JsonContent(
 *              @QA\Schema(type="float"),
 *              @OA\Examples(example="float", value=3.24, summary="A float value."),
 *         )
 *     ),
 *     @QA\Response(response="500", description="Validation error")
 * ),
 * @OA\Post(
 *     tags={"Unathorize"},
 *     path="/api/get-history-course",
 *     description="Currency conversion history",
 *     @QA\RequestBody(
 *          required=true,
 *          @QA\JsonContent(ref="#/components/schemas/CourseHistoryForm")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Result",
 *         @QA\JsonContent(ref="#components/schemas/CurrencyConversionHistory")
 *     ),
 *     @QA\Response(response="500", description="Validation error")
 * ),
 */
class ConverterApi
{
    public function index()
    {
        return 'api';
    }

    /**
     * @return float|string[]
     */
    public function convert()
    {
        $model = new Course();
        $form = new ConvertForm();
        $form->load(App::getPostParams());

        if(
            !empty($form->fromCharCode)
            && !empty($form->toCharCode)
            &&($form->fromCharCode != $form->toCharCode)
        ) {
            $form=$model->setFromTo($form);

            if($form) {
                $res = $form->val * ($form->getFrom()/$form->getTo()); //formula for convert valutes
                return round($res,2);
            }
            return Response::internalErr();
        }
        return Response::internalErr("can not parse");
    }

    /**
     * @return array[]|string[]|false
     */
    public function getHistoryChangeCourse()
    {
        $model = new CourseHistoryForm();
        $model->load(App::getPostParams());
        return $model->historyChangeCourse();
    }
}