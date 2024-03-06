<?php

namespace App\models;


use App\utils\Model;
use App\utils\Db;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="Curse",
 *   required={"char_code","vunit_rate","created_at"}
 * ),
 * @OA\Property(
 *     property="char_code",
 *     type="string",
 *     description="Char code of valute (USD,EUR,RUB...)",
 *     example="EUR"
 * ),
 * @OA\Property(
 *     property="vunit_rate",
 *     type="string",
 *     description="Course currency",
 *     example="1.08"
 * ),
 * @OA\Property(
 *     property="created_at",
 *     type="string",
 *     description="Created date",
 *     example="07-03-2024"
 *  ),
 * @property string $char_code
 * @property float $vunit_rate
 * @property-read  string $created_at
 */
class Course extends Model
{
    const URL_RUB = "http://www.cbr.ru/scripts/XML_daily.asp";

    public static function tableName(): string
    {
        return "course";
    }

    public function validation()
    {
        return !is_numeric($this->char_code) && is_float($this->vunit_rate);
    }

    /**
     * Setting variables "from" and "to"

     */
    public function setFromTo(ConvertForm $form): ConvertForm|bool
    {
        $ans = true;
        /**
         * if we convert value from rubls or to
         * then we shoould set value for rubls 1 or val value for
         * correct work of formula
         */
        if($form->fromCharCode == "RUB" || $form->toCharCode == "RUB"){
            if($form->fromCharCode == "RUB"){
                $form->setFrom(1);
                $to = $this->findByCharCode($form->toCharCode);
                ($to)?$form->setTo((float)$to["vunit_rate"]):$ans=false;
            } else {
                $form->setTo(1);
                $from = $this->findByCharCode($form->fromCharCode);
                ($from)?$form->setFrom((float)$from["vunit_rate"]):$ans=false;
            }
        } else {

            $from = $this->findByCharCode($form->fromCharCode);
            $to = $this->findByCharCode($form->toCharCode);

            ($from)?$form->setFrom((float)$from["vunit_rate"]):$ans=false;
            ($to)?$form->setTo((float)$to["vunit_rate"]):$ans=false;
        }
        return ($ans)?$form:false;
    }

    private function findByCharCode(string $charCode)
    {
        try {
            $pdo = $this->db
                ->pdo
                ->prepare(
                    "SELECT * FROM course WHERE char_code=:char_code ORDER BY created_at ASC LIMIT 1"
                );
            $pdo->bindParam(":char_code",$charCode);
            $pdo->execute();
            $res=$pdo->fetch();
        } catch (\PDOException $e)
        {
            throw new \PDOException($e->getMessage());
        }
        return $res;
    }

    /**
     * Parse for table course and valute
     * @return \SimpleXMLElement|bool
     */
    public function parseXml():\SimpleXMLElement|bool
    {
        $xml = $this->checkConnect();
        if($xml instanceof ResponseInterface){
            $body = $xml->getBody();
            $xml = simplexml_load_string($body);
            $currencies = ($xml)?$xml->Valute:false;
        } else {
            $currencies = false;
        }
        return $currencies;
    }

    /**
     * Checking whether the request is being executed
     * @param bool $hasError
     * @return ResponseInterface
     */
    public function checkConnect():ResponseInterface|bool
    {

        $client = new Client();
        try {
            $res = $client->request('GET',self::URL_RUB);
        } catch (ClientException $e) {
            $res = false;
            $response = $e->getResponse();
            echo match ($response->getStatusCode()) {
                403 => "Forbidden",
                404 => "Not Found",
                500 => "Inner error",
                default => "Unknown error",
            };

        }
        return $res;
    }
}