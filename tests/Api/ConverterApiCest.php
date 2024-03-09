<?php


namespace Tests\Api;

use Codeception\Util\Fixtures;
use Tests\Support\ApiTester;

class ConverterApiCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function convert(ApiTester $I)
    {
        $I->sendPost("/convert",["fromCharCode"=>"EUR","toCharCode"=>"RUB","val"=>1000]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['data'=>"98876.7 RUB"]);
    }

    public function wrongConvert(ApiTester $I)
    {
        $I->sendPost(
            "/convert"
        );
        $I->seeResponseCodeIs(500);
        $I->seeResponseContainsJson(['data'=>['message'=>'Not valid']]);
    }

    public function historyChangeCourse(ApiTester $I)
    {
        $I->sendPost(
            "/get-history-course",
            ["charCode"=>"EUR","dateFrom"=>"08-03-2024","dateTo"=>"09-03-2024"]
        );
        $I->seeResponseCodeIs(200);
    }

    public function wrongHistoryChangeCourse(ApiTester $I)
    {
        $I->sendPost(
            "/get-history-course"
        );
        $I->seeResponseCodeIs(500);
        $I->seeResponseContainsJson(['data'=>['message'=>'Not valid']]);
    }
}
